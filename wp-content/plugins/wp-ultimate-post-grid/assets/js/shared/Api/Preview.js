const previewEndpoint = wpupg_admin.endpoints.preview;

import ApiWrapper from '../ApiWrapper';

export default {
    grid( grid ) {
        const data = {
            grid,
        };

        return ApiWrapper.call( previewEndpoint, 'POST', data );
    },
};
