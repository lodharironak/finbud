import React from 'react';

import { __wpupg } from 'Shared/Translations';
import FieldColor from './FieldColor';
 
const FieldColors = (props) => {
    return (
        <div className="wpupg-admin-modal-field-colors">
            {
                props.colors.map( (color, index) => (
                    <div className="wpupg-admin-modal-field-colors-color" key={ index }>
                        <FieldColor
                            value={ color.value }
                            onChange={ color.onChange }
                        />
                        <div className="wpupg-admin-modal-field-colors-color-label">
                            { color.label }
                        </div>
                    </div>
                ))
            }
        </div>
    );
}
export default FieldColors;
