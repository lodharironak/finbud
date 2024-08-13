import React, { Fragment } from 'react';

import EditMode from 'Modal/general/EditMode';
import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

import ButtonStyle from '../Shared/ButtonStyle';

const FilterClear = (props) => {
    const { options } = props;

    let modes = {
        general: {
            label: __wpupg( 'Clear Filter Options' ),
            block: (
                <Fragment>
                    <Field
                        value={ options.clear_button_text }
                        onChange={ ( value ) => { props.onChange({ clear_button_text: value }); }}
                        type="text"
                        label={ __wpupg( 'Button Text' ) }
                    />
                </Fragment>
            ),
        },
    }

    modes['styling'] = {
        label: __wpupg( 'Button Styling' ),
        block: (
            <Fragment>
                <ButtonStyle
                    grid={ props.grid }
                    options={ props.options }
                    style={ props.options.style }
                    states={ {
                        default: __wpupg( 'Default' ),
                        hover: __wpupg( 'Hover' ),
                    } }
                    onChange={ ( style ) => {
                        props.onChange({
                            style: {
                                ...props.options.style,
                                ...style,
                            },
                        });
                    }}
                />
                <Field
                    value={ options.inactive_opacity }
                    onChange={ ( value ) => { props.onChange({ inactive_opacity: value }); }}
                    type="number"
                    min="0"
                    max="100"
                    suffix="%"
                    label={ __wpupg( 'Inactive Opacity' ) }
                    help={ __wpupg( 'Button is inactive when no filter selections have been made.' ) }
                />
            </Fragment>
        ),
    }

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default FilterClear;
