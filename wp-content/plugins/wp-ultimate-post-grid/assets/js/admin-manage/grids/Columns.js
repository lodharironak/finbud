import React from 'react';
import he from 'he';
 
import TextFilter from '../general/TextFilter';
import Api from 'Shared/Api';
import Icon from 'Shared/Icon';
import { __wpupg } from 'Shared/Translations';
import CopyToClipboardIcon from 'Shared/CopyToClipboardIcon';

import '../../../css/admin/manage/grids.scss';

export default {
    getColumns( grids ) {
        let columns = [
            {
                Header: __wpupg( 'Sort:' ),
                id: 'actions',
                headerClassName: 'wpupg-admin-table-help-text',
                sortable: false,
                width: wpupg_admin.addons.premium ? 100 : 70,
                Filter: () => (
                    <div>
                        { __wpupg( 'Filter:' ) }
                    </div>
                ),
                Cell: row => (
                    <div className="wpupg-admin-manage-actions">
                        <Icon
                            type="edit"
                            title={ __wpupg( 'Edit Grid' ) }
                            onClick={() => {
                                WPUPG_Modal.open('edit', { grid: row.original, saveCallback: () => grids.refreshData() });
                            }}
                        />
                        {
                            true === wpupg_admin.addons.premium
                            &&
                            <Icon
                                type="duplicate"
                                title={ __wpupg( 'Clone Grid' ) }
                                onClick={() => {
                                    WPUPG_Modal.open( 'create', {
                                        grid: row.original,
                                        cloneGrid: true,
                                        saveCallback: () => grids.refreshData(),
                                    });
                                }}
                            />
                        }
                        <Icon
                            type="delete"
                            title={ __wpupg( 'Delete Grid' ) }
                            onClick={() => {
                                if( confirm( `${ __wpupg( 'Are you sure you want to delete' ) } "${row.original.name}"?` ) ) {
                                    Api.grid.delete(row.original.id).then(() => grids.refreshData());
                                }
                            }}
                        />
                    </div>
                ),
            },{
                Header: '#',
                id: 'id',
                accessor: 'id',
                width: 65,
                Filter: (props) => (<TextFilter {...props}/>),
            },{
                Header: __wpupg( 'ID' ),
                id: 'slug',
                accessor: 'slug',
                width: 150,
                Filter: (props) => (<TextFilter {...props}/>),
            },{
                Header: __wpupg( 'Date' ),
                id: 'date',
                accessor: 'date',
                width: 150,
                Filter: (props) => (<TextFilter {...props}/>),
            },{
                Header: __wpupg( 'Name' ),
                id: 'name',
                accessor: 'name',
                width: 300,
                Filter: (props) => (<TextFilter {...props}/>),
                Cell: row => row.value ? he.decode(row.value) : null,
            },
        ];
        
        if ( wpupg_admin_manage_modal.multilingual ) {
            columns.push(
                {
                    Header: __wpupg( 'Language' ),
                    id: 'language',
                    accessor: 'language',
                    width: 150,
                    Filter: ({ filter, onChange }) => (
                        <select
                            onChange={event => onChange(event.target.value)}
                            style={{ width: '100%', fontSize: '1em' }}
                            value={filter ? filter.value : 'all'}
                        >
                            <option value="all">{ __wpupg( 'All Languages' ) }</option>
                            {
                                Object.values(wpupg_admin_manage_modal.multilingual.languages).map((language, index) => {
                                    return (
                                        <option value={ language.value } key={index}>{ `${ language.value } - ${ he.decode( language.label ) }` }</option>
                                    )
                                })
                            }
                        </select>
                    ),
                    Cell: row => {
                        const language = wpupg_admin_manage_modal.multilingual.languages.hasOwnProperty( row.value ) ? wpupg_admin_manage_modal.multilingual.languages[ row.value ] : false;
                
                        if ( ! language ) {
                            return (<div></div>);
                        } else {
                            return (
                                <div>{ `${ language.value } - ${ he.decode( language.label ) }` }</div>
                            )
                        }
                    },
                }
            );
        }

        columns.push(
            {
                Header: __wpupg( 'Shortcode' ),
                id: 'shortcode',
                accessor: 'slug',
                width: 400,
                sortable: false,
                filterable: false,
                Cell: row => {
                    let id = row.value;

                    if ( ! id ) {
                        id = row.original.id;
                    }

                    const shortcode = `[wpupg-grid-with-filters id="${ id }"]`;

                    return (
                        <div className="wpupg-admin-manage-shortcode-container">
                            <CopyToClipboardIcon
                                text={shortcode}
                                type="text"
                            />
                            {/* <span className="wpupg-admin-manage-shortcode">{ shortcode }</span> */}
                        </div>
                    )
                },
            }
        )

        return columns;
    }
};