import React, { Fragment } from 'react';

import EditMode from 'Modal/general/EditMode';
import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const sizingFields = ( props, device ) => {
    return (
        <Fragment>
            <Field
                value={ props.grid[ `layout_${ device }_sizing` ] }
                onChange={ ( value ) => {
                    props.onGridChange({
                        [ `layout_${ device }_sizing` ]: value,
                    });
                }}
                type="dropdown"
                label={ __wpupg( 'Item Sizing' ) }
                options={[
                    {
                        value: 'fixed',
                        label: __wpupg( 'Fixed Item Width' ),
                    },
                    {
                        value: 'columns',
                        label: __wpupg( 'Set number of Columns' ),
                    },
                    {
                        value: 'ignore',
                        label: __wpupg( 'Let item template control sizing' ),
                    },
                ]}
            />
            {
                'fixed' === props.grid[ `layout_${ device }_sizing` ]
                &&
                <Field
                    value={ props.grid[ `layout_${ device }_sizing_fixed` ] }
                    onChange={ ( value ) => {
                        props.onGridChange({
                            [ `layout_${ device }_sizing_fixed` ]: value,
                        });
                    }}
                    type="number"
                    min="1"
                    label={ __wpupg( 'Item Width' ) }
                    suffix="px"
                />
            }
            {
                'columns' === props.grid[ `layout_${ device }_sizing` ]
                &&
                <Field
                    value={ props.grid[ `layout_${ device }_sizing_columns` ] }
                    onChange={ ( value ) => {
                        props.onGridChange({
                            [ `layout_${ device }_sizing_columns` ]: value,
                        });
                    }}
                    type="number"
                    min="1"
                    label={ __wpupg( 'Number of Columns' ) }
                />
            }
            {
                'ignore' !== props.grid[ `layout_${ device }_sizing` ]
                &&
                <Field
                    value={ props.grid[ `layout_${ device }_sizing_margin` ] }
                    onChange={ ( value ) => {
                        props.onGridChange({
                            [ `layout_${ device }_sizing_margin` ]: value,
                        });
                    }}
                    type="number"
                    min="0"
                    label={ __wpupg( 'Item Margin' ) }
                    suffix="px"
                />
            }
        </Fragment>
    );
}

const SectionLayout = (props) => {
    const modes = {
        desktop: {
            label: __wpupg( 'Default/Desktop' ),
            block: (
                <Fragment>
                    <Field
                        value={ props.grid.layout_mode }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                layout_mode: value,
                            });
                        }}
                        type="dropdown"
                        label={ __wpupg( 'Layout Style' ) }
                        options={[
                            {
                                value: 'masonry',
                                label: __wpupg( 'Masonry (Pinterest like)' ),
                            },
                            {
                                value: 'fitRows',
                                label: __wpupg( 'Items in rows' ),
                            },
                            {
                                value: 'fitRowsHeight',
                                label: __wpupg( 'Items in rows (force same height)' ),
                            }
                        ]}
                    />
                    {
                        'masonry' === props.grid.layout_mode
                        && ! props.grid.layout_tablet_different
                        && ! props.grid.layout_mobile_different
                        &&
                        <Field
                            value={ props.grid.centered }
                            onChange={ ( value ) => {
                                props.onGridChange({
                                    centered: value,
                                });
                            }}
                            type="checkbox"
                            label={ __wpupg( 'Center Grid' ) }
                            help={ __wpupg( 'This option will only work with Masonry layout style and the same layout for tablet and mobile.' ) }
                        />
                    }
                    <Field
                        value={ props.grid.rtl_mode }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                rtl_mode: value,
                            });
                        }}
                        type="checkbox"
                        label={ __wpupg( 'RTL Mode' ) }
                        help={ __wpupg( 'When enabled, the grid will position items from Right To Left.' ) }
                    />
                    { sizingFields( props, 'desktop' ) }
                </Fragment>
            ),
        },
        tablet: {
            label: __wpupg( 'Tablet' ),
            block: (
                <Fragment>
                    <Field
                        value={ props.grid.layout_tablet_different }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                layout_tablet_different: value,
                            });
                        }}
                        type="checkbox"
                        label={ __wpupg( 'Use different layout for Tablet' ) }
                    />
                    {
                        props.grid.layout_tablet_different
                        && sizingFields( props, 'tablet' )
                    }
                </Fragment>
            ),
        },
        mobile: {
            label: __wpupg( 'Mobile' ),
            block: (
                <Fragment>
                    <Field
                        value={ props.grid.layout_mobile_different }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                layout_mobile_different: value,
                            });
                        }}
                        type="checkbox"
                        label={ __wpupg( 'Use different layout for Mobile' ) }
                    />
                    {
                        props.grid.layout_mobile_different
                        && sizingFields( props, 'mobile' )
                    }
                </Fragment>
            ),
        },
    };

    return (
        <Fragment>
            <EditMode
                modes={ modes }
            />
        </Fragment>
    );
}
export default SectionLayout;
