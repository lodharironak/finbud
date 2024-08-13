const manageEndpoint = wpupg_admin.endpoints.manage;

import ApiWrapper from '../ApiWrapper';

let gettingData = false;
let gettingDataNextArgs = false;

export default {
    getData(args) {
        if ( ! gettingData ) {
            return this.getDataDebounced(args);
        } else {
            gettingDataNextArgs = args;
            return new Promise(r => r(false));
        }
    },
    getDataDebounced(args) {
        gettingData = true;

        return ApiWrapper.call( `${manageEndpoint}/${args.route}`, 'POST', args ).then(json => {
            // Check if another request is queued.
            if ( gettingDataNextArgs ) {
                const newArgs = gettingDataNextArgs;
                gettingDataNextArgs = false;

                return this.getDataDebounced(newArgs);
            } else {
                // Return this request.
                gettingData = false;
                return json;
            }
        });
    },
    bulkEdit(route, type, ids, action) {
        const data = {
            type,
            ids,
            action,
        };

        return ApiWrapper.call( `${manageEndpoint}/${route}/bulk`, 'POST', data );
    },
};
