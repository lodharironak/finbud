import React, { Component } from 'react';
import { withRouter } from 'react-router';

import '../../css/admin/manage/notices.scss';

import Api from 'Shared/Api';
import Icon from 'Shared/Icon';
import { __wpupg } from 'Shared/Translations';

class Notices extends Component {
    render() {
        if ( ! wpupg_admin_manage_modal.notices || ! wpupg_admin_manage_modal.notices.length ) {
            return null;
        }

        return (
            <div className="wpupg-admin-manage-notices">
                {
                    wpupg_admin_manage_modal.notices.map((notice, index) => {
                        // Check if notice already dismissed.
                        if ( notice.dismissed ) {
                            return null;
                        }

                        // Check if notice should show up in a specific location only.
                        if ( false !== notice.location && this.props.location.pathname !== '/' + notice.location ) {
                            return null;
                        }

                        return (
                            <div className="wpupg-admin-notice" key={ index }>
                                <div className="wpupg-admin-notice-content">
                                    {
                                        notice.title
                                        ?
                                        <div className="wpupg-admin-notice-title">{ notice.title }</div>
                                        :
                                        null
                                    }
                                    <div
                                        className="wpupg-admin-notice-text"
                                        dangerouslySetInnerHTML={ { __html: notice.text } }
                                    />
                                </div>
                                {
                                    notice.dismissable
                                    &&
                                    <div className="wpupg-admin-notice-dismiss">
                                        <Icon
                                            title={ __wpupg( 'Remove Notice' ) }
                                            type="close"
                                            onClick={() => {
                                                Api.general.dismissNotice( notice.id );
                                                notice.dismissed = true;
                                                this.forceUpdate();
                                            }}
                                        />
                                    </div>
                                }
                            </div>
                        )
                    })
                }
            </div>
        );
    }
}

export default withRouter(Notices)