const gridEndpoint = wpupg_admin.endpoints.grid;

import ApiWrapper from '../ApiWrapper';

export default {
    get(id) {
        return ApiWrapper.call( `${gridEndpoint}/${id}` );
    },
    save(asNewGrid, grid) {
        const data = {
            'post_status': 'publish',
            grid,
        };
        const url = asNewGrid ? gridEndpoint : `${gridEndpoint}/${grid.id}`;

        return ApiWrapper.call( url, 'POST', data );
    },
    delete(id) {
        return ApiWrapper.call( `${gridEndpoint}/${id}`, 'DELETE' );
    },
};
