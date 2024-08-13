import React from 'react';
import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';

import { __wpupg } from 'Shared/Translations';
 
const FieldOrder = (props) => {
    let allOptions = [ ...props.options ];
    let orderToShow = [];

    // First follow the current order, but only include those that are still an option.
    for ( let value of props.value ) {
        const matchIndex = allOptions.findIndex( (option) => option.value === value );

        if ( -1 < matchIndex ) {
            const match = allOptions.splice( matchIndex, 1 )[0];
            orderToShow.push( match );
        }
    }

    // Next, include the rest of the options that haven't been removed.
    orderToShow = [
        ...orderToShow,
        ...allOptions,
    ];

    const onDragEnd = ( result ) => {
        if ( result.destination ) {
            let newOrder = JSON.parse( JSON.stringify( orderToShow ) );
            const sourceIndex = result.source.index;
            const destinationIndex = result.destination.index;

            const item = newOrder.splice( sourceIndex, 1 )[0];
            newOrder.splice( destinationIndex, 0, item );

            // Only need values themselves.
            const newValue = newOrder.map( (item) => item.value );

            props.onChange( newValue );
        }
    }

    return (
        <div className="wpupg-admin-modal-field-order">
            <DragDropContext
                onDragEnd={ onDragEnd }
            >
                <Droppable
                    droppableId={ props.id }
                >
                    {(provided, snapshot) => (
                        <div
                            className={`${ snapshot.isDraggingOver ? ' wpupg-admin-modal-field-order-draggingover' : ''}`}
                            ref={provided.innerRef}
                            {...provided.droppableProps}
                        >
                            {
                                orderToShow.map((item, index) => (
                                    <Draggable
                                        draggableId={ `${ props.id }-item-${ item.value }` }
                                        index={ index }
                                        key={ item.value }
                                    >
                                        {(provided, snapshot) => {
                                            return (
                                                <div
                                                    className="wpupg-admin-modal-field-order-item"
                                                    ref={provided.innerRef}
                                                    {...provided.draggableProps}
                                                    {...provided.dragHandleProps}
                                                >
                                                    { item.label }
                                                </div>
                                            )
                                        }}
                                    </Draggable>
                                ))
                            }
                            {provided.placeholder}
                        </div>
                    )}
                </Droppable>
            </DragDropContext>
        </div>
    );
}
export default FieldOrder;
