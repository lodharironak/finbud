import React from 'react';

import { __wpupg } from 'Shared/Translations';
 
const FieldColumns = (props) => {
    return (
        <div className="wpupg-admin-modal-field-columns">
            {
                props.columns.map( (column, index) => (
                    <div className="wpupg-admin-modal-field-columns-columns" key={ index }>
                        { column }
                    </div>
                ))
            }
        </div>
    );
}
export default FieldColumns;
