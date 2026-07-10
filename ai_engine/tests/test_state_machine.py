from ai_engine.state_machine import SquatStateMachine

fsm = SquatStateMachine()

angles = [

    180,

    170,

    160,

    145,

    130,

    115,

    130,

    145,

    170

]

for angle in angles:

    print(

        fsm.update(angle)

    )
