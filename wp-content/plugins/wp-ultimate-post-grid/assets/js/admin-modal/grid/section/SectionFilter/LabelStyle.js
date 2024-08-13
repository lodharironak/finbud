import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const LabelStyle = (props) => {
    return (
        <Fragment>
            <Field
                value={ props.style.label_display }
                onChange={ ( value ) => { props.onChange({ label_display: value }); }}
                type="dropdown"
                options={[
                    {
                        value: 'block',
                        label: __wpupg( 'On its own line' ),
                    },
                    {
                        value: 'inline',
                        label: __wpupg( 'In line with the filter' ),
                    },
                ]}
                label={ __wpupg( 'Display' ) }
            />
            <Field
                value={ props.style.label_style }
                onChange={ ( value ) => { props.onChange({ label_style: value }); }}
                type="dropdown"
                options={[
                    {
                        value: 'normal',
                        label: __wpupg( 'Normal' ),
                    },
                    {
                        value: 'bold',
                        label: __wpupg( 'Bold' ),
                    },
                    {
                        value: 'underline',
                        label: __wpupg( 'Underlined' ),
                    },
                    {
                        value: 'italic',
                        label: __wpupg( 'Italic' ),
                    },
                ]}
                label={ __wpupg( 'Style' ) }
            />
            <Field
                value={ props.style.label_font_size }
                onChange={ ( value ) => { props.onChange({ label_font_size: value }); } }
                type="number"
                min="0"
                label={ __wpupg( 'Font Size' ) }
                suffix="px"
            />
            {
                'block' === props.style.label_display
                &&
                <Field
                    value={ props.style.label_alignment }
                    onChange={ ( value ) => { props.onChange({ label_alignment: value }); }}
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
            }
        </Fragment>
    );
}
export default LabelStyle;
