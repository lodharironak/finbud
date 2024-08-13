import React, { Fragment } from 'react';
const { hooks } = WPUltimatePostGrid['wp-ultimate-post-grid/dist/shared'];

import Field from 'Modal/field';
import EditMode from 'Modal/general/EditMode';
import { __wpupg } from 'Shared/Translations';

const SectionLimit = (props) => {
    const specificRules = hooks.applyFilters( 'limitItemsRules', {});

    const modes = hooks.applyFilters( 'limitItems', {
        general: {
            label: __wpupg( 'General' ),
            block: (
                <Fragment>
                    {
                        'posts' === props.grid.type
                        &&
                        <Fragment>
                            <Field
                                value={ props.grid.limit_posts_offset }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        limit_posts_offset: value,
                                    });
                                }}
                                type="number"
                                label={ __wpupg( 'Offset First # Items' ) }
                                help={ __wpupg( 'Exclude the first x items from getting displayed the grid.' ) }
                            />
                            <Field
                                value={ props.grid.limit_posts_number }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        limit_posts_number: value,
                                    });
                                }}
                                type="number"
                                min="1"
                                label={ __wpupg( 'Limit Total # Items' ) }
                                help={ __wpupg( 'Limit the total number of items in the grid.' ) }
                            />
                            <Field
                                value={ props.grid.images_only }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        images_only: value,
                                    });
                                }}
                                type="checkbox"
                                label={ __wpupg( 'Images Only' ) }
                                help={ __wpupg( 'Only display items that have a featured or custom image set.' ) }
                            />
                        </Fragment>
                    }
                    {
                        'terms' === props.grid.type
                        &&
                        <Fragment>
                            <Field
                                value={ props.grid.terms_images_only }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        terms_images_only: value,
                                    });
                                }}
                                type="checkbox"
                                label={ __wpupg( 'Images Only' ) }
                                help={ __wpupg( 'Only display terms that have a grod image set.' ) }
                            />
                            <Field
                                value={ props.grid.terms_hide_empty }
                                onChange={ ( value ) => {
                                    props.onGridChange({
                                        terms_hide_empty: value,
                                    });
                                }}
                                type="checkbox"
                                label={ __wpupg( 'Hide Empty' ) }
                                help={ __wpupg( 'Hide terms without associated posts.' ) }
                            />
                        </Fragment>
                    }
                </Fragment>
            ),
        },
        specific: {
            label: __wpupg( 'Specific Rules' ),
            block: (
                <Fragment>
                    {
                    specificRules.hasOwnProperty( props.grid.type )
                    ?
                    specificRules[ props.grid.type ](props)
                    :
                    <p style={ { color: 'darkred' } }>
                        { __wpupg( 'This feature is only available in' ) } <a href="https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/">WP Ultimate Post Grid Premium</a>.
                    </p>
                    }
                </Fragment>
            ),
        },
    } );

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default SectionLimit;
