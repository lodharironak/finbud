import React, { Fragment } from 'react';

import Field from 'Modal/field';
import { __wpupg } from 'Shared/Translations';

const SectionOther = (props) => {
    return (
        <Fragment>
            <Field
                value={ props.grid.metadata }
                onChange={ ( value ) => {
                    props.onGridChange({
                        metadata: value,
                    });
                }}
                type="checkbox"
                label={ __wpupg( 'Output ItemList Metadata' ) }
                help={ __wpupg( 'Output ItemList Metadata for the grid items that appear on initial load. This allows some metadata types (recipes, movies, ...) to appear in the Google Carousel.' ) }
            />
            {
                props.grid.metadata
                &&
                <Fragment>
                    <Field
                        value={ props.grid.metadata_name }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                metadata_name: value,
                            });
                        }}
                        type="text"
                        label={ __wpupg( 'Metadata Name' ) }
                        help={ __wpupg( 'Name to be used in the metadata for this ItemList. Can be empty.' ) }
                    />
                    <Field
                        value={ props.grid.metadata_description }
                        onChange={ ( value ) => {
                            props.onGridChange({
                                metadata_description: value,
                            });
                        }}
                        type="text"
                        label={ __wpupg( 'Metadata Description' ) }
                        help={ __wpupg( 'Description to be used in the metadata for this ItemList. Can be empty.' ) }
                    />
                </Fragment>
            }
            {
                'posts' === props.grid.type
                &&
                <Field
                    value={ props.grid.deeplinking }
                    onChange={ ( value ) => {
                        props.onGridChange({
                            deeplinking: value,
                        });
                    }}
                    type="checkbox"
                    label={ __wpupg( 'Enable deeplinking' ) }
                    help={ __wpupg( 'When deeplinking is enabled the URL will automatically get updated to reflect the position in the grid. Visitors will be able to copy that link to go back to it.' ) }
                />
            }
            <Field
                value={ props.grid.empty_message }
                onChange={ ( value ) => {
                    props.onGridChange({
                        empty_message: value,
                    });
                }}
                type="tinymce"
                label={ __wpupg( 'Empty Message' ) }
                help={ __wpupg( 'Message to show when there are no items to display.' ) }
            />
        </Fragment>
    );
}
export default SectionOther;
