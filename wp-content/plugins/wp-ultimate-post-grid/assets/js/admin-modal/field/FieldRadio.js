import React, {Fragment} from 'react';
 
const FieldRadio = (props) => {
    return (
        <Fragment>
            {
                props.options.map((option) => (
                    <div className="wpupg-admin-modal-link-field-radio-option" key={option.value}>
                        <input
                            type="radio"
                            value={option.value}
                            name={`wpupg-admin-radio-${props.id}`}
                            id={`wpupg-admin-radio-${props.id}-${option.value}`}
                            checked={props.value == option.value}
                            onChange={(e) => {
                                props.onChange(e.target.value);
                            }}
                        /><label htmlFor={`wpupg-admin-radio-${props.id}-${option.value}`}>{ option.label }</label>
                    </div>
                ))
            }
        </Fragment>
    );
}
export default FieldRadio;