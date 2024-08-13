import React, { Fragment } from 'react';

import EditMode from 'Modal/general/EditMode';
import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

import ButtonStyle from '../Shared/ButtonStyle';

const PaginationPages = (props) => {
    const { options } = props;

    let modes = {
        general: {
            label: __wpupg( 'General' ),
            block: (
                <Fragment>
                    <Field
                        value={ options.posts_per_page }
                        onChange={ ( value ) => { props.onChange({ posts_per_page: value }); }}
                        type="number"
                        min="1"
                        label={ __wpupg( 'Posts per page' ) }
                    />
                    <Field
                        value={ options.max_buttons ? options.max_buttons : '' } // Use empty field instead of 0.
                        onChange={ ( value ) => { props.onChange({ max_buttons: value }); }}
                        type="number"
                        min="5"
                        label={ __wpupg( 'Max # Buttons' ) }
                        help={ __wpupg( 'The maximum number of buttons to show. Will add gaps if the number of pages exceeds this. Should be a minimum of 5.' ) }
                    />
                    <Field
                        value={ options.adaptive_pages }
                        onChange={ ( value ) => { props.onChange({ adaptive_pages: value }); }}
                        type="checkbox"
                        label={ __wpupg( 'Adaptive Pages' ) }
                        help={ __wpupg( 'When enabled, the pages automatically adjust after filtering. Otherwise, filtering only filters the current page.' ) }
                    />
                </Fragment>
            ),
        },
        styling: {
            label: __wpupg( 'Button Styling' ),
            block: (
                <Fragment>
                    <ButtonStyle
                        grid={ props.grid }
                        options={ props.options }
                        style={ props.options.style }
                        onChange={ ( style ) => {
                            props.onChange({
                                style: {
                                    ...props.options.style,
                                    ...style,
                                },
                            });
                        }}
                    />
                </Fragment>
            ),
        }
    }

    return (
        <EditMode
            modes={ modes }
        />
    );
}
export default PaginationPages;
