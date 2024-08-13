import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const GeneralStyle = (props) => {
    return (
        <Fragment>
            <Field
                value={ props.style.display }
                onChange={ ( value ) => { props.onChange({ display: value }); }}
                type="dropdown"
                options={[
                    {
                        value: 'block',
                        label: __wpupg( 'Top - Each filter on its own line' ),
                    },
                    {
                        value: 'inline',
                        label: __wpupg( 'Top - Filters inline with eachother' ),
                    },
                    {
                        value: 'left',
                        label: __wpupg( 'Side - Filters on the left side to the grid' ),
                    },
                    {
                        value: 'right',
                        label: __wpupg( 'Side - Filters on the right side to the grid' ),
                    },
                ]}
                label={ __wpupg( 'Display' ) }
            />
            {
                'inline' === props.style.display
                &&
                <Fragment>
                    <Field
                        value={ props.style.alignment }
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
                            {
                                value: 'spaced',
                                label: __wpupg( 'Spaced evenly' ),
                            },
                        ]}
                        label={ __wpupg( 'Alignment' ) }
                    />
                    <Field
                        type="columns"
                        columns={[
                            <Fragment>
                                <input
                                    type="number"
                                    value={ props.style.spacing_vertical }
                                    min="0"
                                    onChange={(e) => {
                                        props.onChange({ spacing_vertical: e.target.value });
                                    }}
                                /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'vertical' ) })</span>
                            </Fragment>,
                            <Fragment>
                                <input
                                    type="number"
                                    value={ props.style.spacing_horizontal }
                                    min="0"
                                    onChange={(e) => {
                                        props.onChange({ spacing_horizontal: e.target.value });
                                    }}
                                /> <span className="wpupg-admin-modal-field-number-suffix">px ({ __wpupg( 'horizontal' ) })</span>
                            </Fragment>
                        ]}
                        label={ __wpupg( 'Spacing' ) }
                    />
                </Fragment>
            }
            {
                ( 'left' === props.style.display || 'right' === props.style.display )
                &&
                <Field
                    value={ props.style.width }
                    onChange={ ( value ) => { props.onChange({ width: value }); } }
                    type="number"
                    min="0"
                    label={ __wpupg( 'Width' ) }
                    help={ __wpupg( 'The width also depends on the width of the individual filters inside' ) }
                    suffix="px"
                />
            }
        </Fragment>
    );
}
export default GeneralStyle;
