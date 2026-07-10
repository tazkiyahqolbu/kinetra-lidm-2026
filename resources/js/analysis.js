const WS_URL = import.meta.env.VITE_ANALYSIS_WS_URL || 'ws://127.0.0.1:8001/ws/squat';

const JPEG_QUALITY = 0.6;
const TARGET_REPS = 8;
const CAPTURE_MAX_WIDTH = 480; // downscaled before sending, keeps inference fast
const MIN_FRAME_GAP_MS = 30; // floor between sends so a fast server can't busy-loop

const video = document.getElementById('squat-video');
const canvas = document.getElementById('squat-canvas');
const overlay = document.getElementById('squat-overlay');
const btnStart = document.getElementById('btn-start');
const btnStop = document.getElementById('btn-stop');

const statDuration = document.getElementById('stat-duration');
const statRepetition = document.getElementById('stat-repetition');
const statAngle = document.getElementById('stat-angle');
const statStatusDot = document.getElementById('stat-status-dot');
const statStatusText = document.getElementById('stat-status-text');
const feedbackList = document.getElementById('feedback-list');

let mediaStream = null;
let socket = null;
let durationIntervalId = null;
let sessionStartedAt = null;
let sessionActive = false;

// running summary accumulated client-side across the whole set, submitted
// once TARGET_REPS is reached (or the user stops early)
const summary = {
    repetition: 0,
    minAngle: null,
    maxAngle: null,
    repHistory: [], // { score, feedback } per completed rep
    angles: [], // full angle time-series, used to draw the session's chart

    // Three representative photos for the first completed rep, mirroring
    // the reference desktop tool's 3-panel report (standing before the
    // descent, deepest flexion, standing after the ascent).
    startFrame: null,
    bottomFrame: null,
    endFrame: null,
    firstRepCaptured: false,
    _lastStandingFrame: null,
    _firstRepMinAngle: null,
};

function formatDuration(ms) {
    const totalSeconds = Math.floor(ms / 1000);
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    return `${minutes}:${String(seconds).padStart(2, '0')}`;
}

function setStatus(text, colorClass) {
    statStatusText.textContent = text;
    statStatusDot.className = `w-3 h-3 rounded-full ${colorClass}`;
}

function drawAnnotatedFrame(base64Jpeg) {
    if (!base64Jpeg) {
        return;
    }

    const img = new Image();

    img.onload = () => {
        overlay.width = img.naturalWidth;
        overlay.height = img.naturalHeight;
        overlay.getContext('2d').drawImage(img, 0, 0);
    };

    img.src = `data:image/jpeg;base64,${base64Jpeg}`;
}

function clearOverlay() {
    const context = overlay.getContext('2d');
    context.clearRect(0, 0, overlay.width, overlay.height);
}

function renderFinalEvaluation() {
    const reps = summary.repHistory;

    const averageScore = reps.length
        ? Math.round(reps.reduce((sum, rep) => sum + rep.score, 0) / reps.length)
        : 0;

    // dedupe feedback by code across all reps, counting how often each occurred
    const counts = new Map();

    reps.forEach((rep) => {
        rep.feedback.forEach((item) => {
            const existing = counts.get(item.code);
            if (existing) {
                existing.count += 1;
            } else {
                counts.set(item.code, { message: item.message, count: 1 });
            }
        });
    });

    feedbackList.innerHTML = Array.from(counts.values())
        .map((item) => `<p class="text-sm text-gray-700">${item.message} (${item.count}/${reps.length}x)</p>`)
        .join('') || '<p class="text-sm text-gray-700">Tidak ada data feedback.</p>';

    setStatus(`Evaluasi selesai - skor rata-rata ${averageScore}`, 'bg-emerald-500');

    return averageScore;
}

function handleFrameResult(message) {
    drawAnnotatedFrame(message.annotated_frame);

    statAngle.textContent = `${message.angle.toFixed(1)}°`;
    statRepetition.textContent = `${message.repetition} / ${TARGET_REPS}`;

    summary.repetition = message.repetition;
    summary.angles.push(message.angle);

    summary.minAngle = summary.minAngle === null ? message.angle : Math.min(summary.minAngle, message.angle);
    summary.maxAngle = summary.maxAngle === null ? message.angle : Math.max(summary.maxAngle, message.angle);

    // Capture the 3 representative photos (standing before / deepest
    // flexion / standing after) for the first rep only, same idea as the
    // reference tool picking one representative cycle for its report.
    if (!summary.firstRepCaptured && message.annotated_frame) {
        if (message.state === 'Standing') {
            summary._lastStandingFrame = message.annotated_frame;
        } else if (
            summary._firstRepMinAngle === null ||
            message.angle < summary._firstRepMinAngle
        ) {
            summary._firstRepMinAngle = message.angle;
            summary.bottomFrame = message.annotated_frame;
        }
    }

    if (message.event === 'REP_COMPLETED' && message.result) {
        summary.repHistory.push({
            score: message.result.movement_score.final,
            feedback: message.result.feedback,
        });

        if (!summary.firstRepCaptured) {
            summary.startFrame = summary._lastStandingFrame;
            summary.endFrame = message.annotated_frame;
            summary.firstRepCaptured = true;
        }

        if (message.repetition >= TARGET_REPS) {
            stopSession();
            return;
        }

        setStatus(`Repetisi ${message.repetition} selesai, lanjutkan...`, 'bg-blue-500');
    } else {
        setStatus(`Terdeteksi: ${message.state}`, 'bg-emerald-500');
    }
}

function handleNoPose(message) {
    drawAnnotatedFrame(message.annotated_frame);
    setStatus('Pose tidak terdeteksi, pastikan seluruh tubuh terlihat.', 'bg-yellow-500');
}

async function initCamera() {
    try {
        mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    } catch (error) {
        setStatus('Tidak bisa mengakses kamera.', 'bg-red-500');
        btnStart.disabled = true;
        return;
    }

    video.srcObject = mediaStream;
    setStatus('Kamera siap, klik "Mulai Rekam" untuk mulai analisis.', 'bg-gray-400');
}

function startSession() {
    if (!mediaStream) {
        setStatus('Kamera belum siap.', 'bg-red-500');
        return;
    }

    summary.repetition = 0;
    summary.minAngle = null;
    summary.maxAngle = null;
    summary.repHistory = [];
    summary.angles = [];
    summary.startFrame = null;
    summary.bottomFrame = null;
    summary.endFrame = null;
    summary.firstRepCaptured = false;
    summary._lastStandingFrame = null;
    summary._firstRepMinAngle = null;
    statRepetition.textContent = `0 / ${TARGET_REPS}`;
    feedbackList.innerHTML = '<p class="text-sm text-gray-700">Feedback akan muncul di sini saat Anda melakukan gerakan.</p>';

    sessionActive = true;

    socket = new WebSocket(WS_URL);
    socket.binaryType = 'arraybuffer';

    socket.onopen = () => {
        socket.send(JSON.stringify({ type: 'start' }));

        sessionStartedAt = Date.now();
        durationIntervalId = setInterval(() => {
            statDuration.textContent = formatDuration(Date.now() - sessionStartedAt);
        }, 1000);

        setStatus('Menganalisis gerakan...', 'bg-blue-500');

        // kick off the self-paced capture loop: one frame in flight at a
        // time, next frame only sent after this one's result comes back -
        // otherwise frames queue up faster than the server can process
        // them and the whole thing appears to "lag then freeze".
        captureAndSendFrame();
    };

    socket.onmessage = (event) => {
        try {
            const message = JSON.parse(event.data);

            if (message.type === 'frame_result') {
                handleFrameResult(message);
            } else if (message.type === 'no_pose') {
                handleNoPose(message);
            }
        } catch (error) {
            // A single malformed/unexpected message must never permanently
            // kill the self-paced capture loop - without this, one bad
            // message means no more frames are ever sent again (looks
            // exactly like a frozen camera).
            setStatus('Terjadi gangguan sesaat, melanjutkan...', 'bg-yellow-500');
        } finally {
            if (sessionActive) {
                setTimeout(captureAndSendFrame, MIN_FRAME_GAP_MS);
            }
        }
    };

    socket.onerror = () => {
        setStatus('Koneksi ke server analisis terputus.', 'bg-red-500');
    };

    socket.onclose = () => {
        // Whatever the reason (server restarted, network hiccup, crash),
        // make sure the loop stops cleanly and the UI says so instead of
        // silently freezing with no explanation.
        if (sessionActive) {
            sessionActive = false;
            clearInterval(durationIntervalId);
            setStatus('Koneksi ke server analisis terputus. Klik "Mulai Rekam" untuk mencoba lagi.', 'bg-red-500');
            btnStart.disabled = false;
            btnStop.disabled = true;
        }
    };

    btnStart.disabled = true;
    btnStop.disabled = false;
}

function captureAndSendFrame() {
    if (!sessionActive || !socket || socket.readyState !== WebSocket.OPEN) {
        return;
    }

    try {
        if (!video.videoWidth || !video.videoHeight) {
            // video metadata not ready this tick - retry shortly instead of
            // stalling forever waiting for a response to a frame that was
            // never sent.
            setTimeout(captureAndSendFrame, MIN_FRAME_GAP_MS);
            return;
        }

        const scale = Math.min(1, CAPTURE_MAX_WIDTH / video.videoWidth);

        const context = canvas.getContext('2d');
        canvas.width = Math.round(video.videoWidth * scale);
        canvas.height = Math.round(video.videoHeight * scale);
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(
            (blob) => {
                if (!blob || !socket || socket.readyState !== WebSocket.OPEN) {
                    // encoding failed or socket closed meanwhile - nothing
                    // was sent, so no server response will ever arrive to
                    // trigger the next attempt. Retry ourselves instead of
                    // leaving the loop stuck forever.
                    if (sessionActive) {
                        setTimeout(captureAndSendFrame, MIN_FRAME_GAP_MS);
                    }
                    return;
                }

                blob.arrayBuffer().then((buffer) => socket.send(buffer));
            },
            'image/jpeg',
            JPEG_QUALITY
        );
    } catch (error) {
        // Never let a single bad frame permanently kill the capture loop.
        if (sessionActive) {
            setTimeout(captureAndSendFrame, MIN_FRAME_GAP_MS);
        }
    }
}

async function stopSession() {
    sessionActive = false;
    clearInterval(durationIntervalId);

    if (socket) {
        // Stop reacting to anything from this socket first - otherwise a
        // frame_result that was already in flight when we decided to stop
        // can arrive right after clearOverlay() and redraw the last
        // annotated frame on top, leaving the camera looking "frozen" on
        // that photo instead of showing live video again.
        socket.onmessage = null;
        socket.onerror = null;
        socket.onclose = null;

        if (socket.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify({ type: 'stop' }));
        }

        socket.close();
    }

    // camera itself stays on - only the analysis session stops
    clearOverlay();

    btnStart.disabled = false;
    btnStop.disabled = true;

    if (summary.repHistory.length > 0) {
        renderFinalEvaluation();
        await submitSummary();
    } else {
        setStatus('Sesi dihentikan sebelum ada repetisi selesai.', 'bg-gray-400');
    }
}

async function submitSummary() {
    if (summary.minAngle === null || summary.maxAngle === null) {
        return;
    }

    const averageScore = Math.round(
        summary.repHistory.reduce((sum, rep) => sum + rep.score, 0) / summary.repHistory.length
    );

    const combinedFeedback = summary.repHistory.flatMap((rep) => rep.feedback);

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    setStatus('Menyimpan hasil sesi...', 'bg-blue-500');

    try {
        const response = await fetch('/student/analysis/summary', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                Accept: 'application/json',
            },
            body: JSON.stringify({
                repetition: summary.repetition,
                rom: summary.maxAngle - summary.minAngle,
                score: averageScore,
                feedback: combinedFeedback,
                angles: summary.angles,
                snapshot_start: summary.startFrame,
                snapshot_bottom: summary.bottomFrame,
                snapshot_end: summary.endFrame,
            }),
        });

        if (!response.ok) {
            const payload = await response.json().catch(() => null);
            throw new Error(payload?.message || `Server merespons status ${response.status}`);
        }

        setStatus(`Hasil latihan tersimpan - skor rata-rata ${averageScore}`, 'bg-emerald-500');
    } catch (error) {
        setStatus(`Gagal menyimpan hasil sesi: ${error.message}`, 'bg-red-500');
    }
}

btnStart.addEventListener('click', startSession);
btnStop.addEventListener('click', stopSession);

initCamera();
