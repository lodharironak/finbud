import React, { Fragment } from 'react';

import Loader from 'Shared/Loader';

const ManageTemplate = (props) => {
    const editable = 'database' === props.template.location;

    return (
        <div className="wpupg-main-container">
            <h2 className="wpupg-main-container-name">Selected Template</h2>
            <div className="wpupg-manage-templates-template-fields">
                <span>Slug: { props.template.slug }</span> | <span>Name: { props.template.name }</span>
            </div>
            <div className="wpupg-manage-templates-template-actions">
                <Fragment>
                    {
                        props.savingTemplate
                        ?
                        <Loader/>
                        :
                        <Fragment>
                            {
                                editable
                                ?
                                <Fragment>
                                    <button
                                        className="button button-primary"
                                        onClick={ () => props.onChangeEditing(true) }
                                    >Edit Template</button>
                                    <button
                                        className="button button-primary"
                                        onClick={() => {
                                            const name = prompt( 'Choose a name for the cloned template' );
                                            
                                            if (name) {
                                                props.onSaveTemplate({
                                                    ...props.template,
                                                    oldSlug: props.template.slug,
                                                    slug: false, // Cloning, so generate new slug.
                                                    name,
                                                });
                                            }
                                        } }
                                    >Clone Template</button>
                                </Fragment>
                                :
                                <button
                                    className="button button-primary"
                                    onClick={() => {
                                        const name = prompt( 'Choose a name for the cloned template' );
                                        
                                        if (name) {
                                            props.onSaveTemplate({
                                                ...props.template,
                                                oldSlug: props.template.slug,
                                                slug: false, // Cloning, so generate new slug.
                                                name,
                                            });
                                            props.onChangeEditing(true);
                                        }
                                    } }
                                >Clone & Edit Template</button>
                            }
                            <button
                                className="button"
                                onClick={() => {
                                    const name = prompt( 'Choose a new name for this template', props.template.name );
                                    
                                    if ( name && name !== props.template.name ) {
                                        props.onSaveTemplate({
                                            ...props.template,
                                            name,
                                        });
                                    }
                                } }
                                disabled={ ! editable }
                            >Rename</button>
                            <button
                                className="button"
                                onClick={() => {
                                    if (confirm( 'Are you sure you want to delete the "' + props.template.name + '" template?' )) {
                                        props.onDeleteTemplate(props.template.slug);
                                    }
                                } }
                                disabled={ ! editable }
                            >Delete</button>
                        </Fragment>        
                    }
                </Fragment>
            </div>
        </div>
    );
}

export default ManageTemplate;