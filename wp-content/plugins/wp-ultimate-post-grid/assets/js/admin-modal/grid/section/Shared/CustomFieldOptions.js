import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';
import Icon from 'Shared/Icon';

const CustomFieldOptions = (props) => {
    const { options } = props;

    return (
        <Fragment>
            <Field
                type="custom"   
                label=""
            >
                 <p>
                    { __wpupg( 'Manually set the values you want to show in this filter, in the order you want.' ) }
                    <br/>{ __wpupg( 'For numeric fields you can also use ranges!' ) } <a href="https://help.bootstrapped.ventures/article/265-custom-field-filters" target="_blank">{ __wpupg( 'Learn More' ) }</a>.
                </p>
            </Field>
            {
                options.custom_field_options.map( ( custom_field_option, index ) => {
                    const allowDown = index < options.custom_field_options.length - 1;
                    const allowUp = 0 < index;

                    return (
                        <Field
                            type="custom"   
                            label={ `${ __wpupg( 'Option' ) } #${index + 1}` }
                        >
                            <div className="wpupg-admin-modal-field-filter">
                                <input
                                    className="wpupg-admin-modal-field-filter-label"
                                    type="text"
                                    value={ custom_field_option.value }
                                    placeholder={ __wpupg( 'Value' ) }
                                    onChange={(e) => {
                                        let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );

                                        newOptions[ index ].value = e.target.value;
                                        
                                        props.onChange({
                                            custom_field_options: newOptions,
                                        });
                                    }}
                                />
                                <input
                                    className="wpupg-admin-modal-field-filter-label"
                                    type="text"
                                    value={ custom_field_option.label }
                                    placeholder={ __wpupg( 'Label' ) }
                                    onChange={(e) => {
                                        let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );

                                        newOptions[ index ].label = e.target.value;

                                        props.onChange({
                                            custom_field_options: newOptions,
                                        });
                                    }}
                                />
                                <div className="wpupg-admin-modal-field-filter-order">
                                    <Icon
                                        type="up"
                                        className={ ! allowUp ? 'wpupg-admin-modal-field-filter-order-disabled' : '' }
                                        onClick={
                                            allowUp
                                            ?
                                            () => {
                                                let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );
                                                newOptions.splice( index - 1, 0, newOptions.splice( index, 1 )[0] );
            
                                                props.onChange({
                                                    custom_field_options: newOptions,
                                                });
                                            }
                                            :
                                            null
                                        }
                                    />
                                    <Icon
                                        type="down"
                                        className={ ! allowDown ? 'wpupg-admin-modal-field-filter-order-disabled' : '' }
                                        onClick={
                                            allowDown
                                            ?
                                            () => {
                                                let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );
                                                newOptions.splice( index + 1, 0, newOptions.splice( index, 1 )[0] );
            
                                                props.onChange({
                                                    custom_field_options: newOptions,
                                                });
                                            }
                                            :
                                            null
                                        }
                                    />
                                </div>
                                <div className="wpupg-admin-modal-field-filter-remove">
                                    <Icon
                                        type="delete"
                                        onClick={() => {
                                            if ( confirm( __wpupg( 'Are you sure you want to remove this option?' ) ) ) {
                                                let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );
                                                newOptions.splice( index, 1 );
            
                                                props.onChange({
                                                    custom_field_options: newOptions,
                                                });
                                            }
                                        }}
                                    />
                                </div>
                            </div>
                        </Field>
                    );
                })
            }
            <Field
                type="custom"   
                label=""
            >
                <a
                    href="#"
                    role="button"
                    onClick={(e) => {
                        e.preventDefault();
                        let newOptions = JSON.parse( JSON.stringify( options.custom_field_options ) );
                        newOptions.push({
                            value: '',
                            label: '',
                        });

                        props.onChange({
                            custom_field_options: newOptions,
                        });
                    }}
                >{ __wpupg( 'Add Option' ) }</a>
            </Field>
        </Fragment>
    );
}
export default CustomFieldOptions;
