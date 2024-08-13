import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const ButtonStyle = (props) => {
    const { style } = props;

    const states = props.hasOwnProperty( 'states' ) ? props.states : {
        default: __wpupg( 'Default' ),
        active: __wpupg( 'Active' ),
        hover: __wpupg( 'Hover' ),
    };

    const getColorsForStates = ( prefix ) => {
        let colors = [];

        for ( let state of Object.keys( states ) ) {
            const key = 'default' === state ? '' : state;
            const label = states[ state ];

            const option = `${prefix}_${ key ? key + '_' : '' }color`;

            colors.push({
                label,
                value: style[ option ],
                onChange: ( value ) => { props.onChange({ [ option ]: value }); }
            });
        }

        return colors;
    };

    return (
        <Fragment>
            <Field
                value={ style.font_size }
                onChange={ ( value ) => { props.onChange({ font_size: value }); } }
                type="number"
                min="0"
                label={ __wpupg( 'Font Size' ) }
                suffix="px"
            />
            <Field
                type="colors"
                colors={ getColorsForStates( 'background' ) }
                label={ __wpupg( 'Background Color' ) }
            />
            <Field
                type="colors"
                colors={ getColorsForStates( 'text' ) }
                label={ __wpupg( 'Text Color' ) }
            />
            <Field
                value={ style.border_width }
                onChange={ ( value ) => { props.onChange({ border_width: value }); } }
                type="number"
                min="0"
                label={ __wpupg( 'Border Width' ) }
                suffix="px"
            />
            {
                0 < style.border_width
                &&
                <Field
                    type="colors"
                    colors={ getColorsForStates( 'border' ) }
                    label={ __wpupg( 'Border Color' ) }
                />
            }
            <Field
                value={ style.border_radius }
                onChange={ ( value ) => { props.onChange({ border_radius: value }); } }
                type="number"
                min="0"
                label={ __wpupg( 'Border Radius' ) }
                suffix="px"
            />
            <Field
                type="columns"
                columns={[
                    <Fragment>
                        <input
                            type="number"
                            value={ style.margin_vertical }
                            min="0"
                            onChange={(e) => {
                                props.onChange({ margin_vertical: e.target.value });
                            }}
                        /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'vertical' ) })</span>
                    </Fragment>,
                    <Fragment>
                        <input
                            type="number"
                            value={ style.margin_horizontal }
                            min="0"
                            onChange={(e) => {
                                props.onChange({ margin_horizontal: e.target.value });
                            }}
                        /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'horizontal' ) })</span>
                    </Fragment>
                ]}
                label={ __wpupg( 'Margin' ) }
            />
            <Field
                type="columns"
                columns={[
                    <Fragment>
                        <input
                            type="number"
                            value={ style.padding_vertical }
                            min="0"
                            onChange={(e) => {
                                props.onChange({ padding_vertical: e.target.value });
                            }}
                        /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'vertical' ) })</span>
                    </Fragment>,
                    <Fragment>
                        <input
                            type="number"
                            value={ style.padding_horizontal }
                            min="0"
                            onChange={(e) => {
                                props.onChange({ padding_horizontal: e.target.value });
                            }}
                        /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'horizontal' ) })</span>
                    </Fragment>
                ]}
                label={ __wpupg( 'Padding' ) }
            />
            <Field
                value={ style.alignment }
                onChange={ ( value ) => { props.onChange({ alignment: value }); }}
                type="dropdown"
                options={[
                    {
                        value: 'left',
                        label: __wpupg( 'Left' ),
                    },
                    {
                        value: 'center',
                        label: __wpupg( 'Center' ),
                    },
                    {
                        value: 'right',
                        label: __wpupg( 'Right' ),
                    },
                ]}
                label={ __wpupg( 'Alignment' ) }
            />
        </Fragment>
    );
}
export default ButtonStyle;
