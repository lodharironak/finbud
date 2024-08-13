import React, { Fragment } from 'react';

import '../../../../css/admin/template/manage.scss';

import ManageTemplate from './ManageTemplate';

const ManageTemplates = (props) => {
    let templatesGrouped = {
        'Our Templates': [],
        'Theme Templates': [],
        'Your Templates': [],
    }

    // Put templates in correct categories.
    Object.entries(props.templates).forEach(([slug, template]) => {    
        if ( 'file' === template.location ) {
            if ( template.custom ) {
                templatesGrouped['Theme Templates'].push(template);
            } else {
                templatesGrouped['Our Templates'].push(template);
            }
        } else {
            templatesGrouped['Your Templates'].push(template);
        }
    });

    return (
        <Fragment>
            <div className="wpupg-main-container">
                <h2 className="wpupg-main-container-name">Need help?</h2>
                <p style={{ textAlign: 'center'}}>Have a look at the <a href="https://help.bootstrapped.ventures/article/216-grid-template-editor" target="_blank">documentation for the Template Editor</a>!</p>
            </div>
            <div className="wpupg-main-container">
                <h2 className="wpupg-main-container-name">Templates</h2>
                {
                    Object.keys(templatesGrouped).map((header, i) => {
                        let templates = templatesGrouped[header];
                        if ( templates.length > 0 ) {
                            return (
                                <Fragment key={i}>
                                    <h3>{ header }</h3>
                                    {
                                        templates.map((template, j) => {
                                            let classes = 'wpupg-manage-templates-template';
                                            classes += props.template.slug === template.slug ? ' wpupg-manage-templates-template-selected' : '';
                                            classes += template.premium && ! wpupg_admin.addons.premium ? ' wpupg-manage-templates-template-premium' : '';

                                            return (
                                                <div
                                                    key={j}
                                                    className={ classes }
                                                    onClick={ () => {
                                                        const newTemplate = props.template.slug === template.slug ? false : template.slug;
                                                        return props.onChangeTemplate(newTemplate);
                                                    }}
                                                >{ template.name }</div>
                                            )
                                        })
                                    }
                                </Fragment>
                            )
                        }
                    })
                }
            </div>
            {
                props.template
                &&
                <ManageTemplate
                    onChangeEditing={ props.onChangeEditing }
                    template={ props.template }
                    onDeleteTemplate={ props.onDeleteTemplate }
                    onChangeTemplate={ props.onChangeTemplate }
                    savingTemplate={ props.savingTemplate }
                    onSaveTemplate={ props.onSaveTemplate }
                />
            }
        </Fragment>
    );
}

export default ManageTemplates;