import axios from 'axios';

const GET = 'GET';
const PATCH = 'PATCH';
const POST = 'POST';
const DELETE = 'DELETE';


export default {
    content: createCrudApis( 'content' ),
    shareable: createCrudApis( 'shareable', {
        async external( id ) {
            return await callApi( GET, `/api/shareable/external/${id}` );
        }
    } )
};

function createCrudApis( apiEndpoint, additionalApis = {} ) {
    let api = {
        async all() {
            return await callApi( GET, `/api/${apiEndpoint}` );
        },
        async get( id ) {
            return await callApi( GET, `/api/${apiEndpoint}/${id}` );
        },
        async create( payload ) {
            return await callApi( POST, `/api/${apiEndpoint}`, payload );
        },
        async update( id, payload ) {
            return await callApi( PATCH, `/api/${apiEndpoint}/${id}`, payload );
        },
        async delete( id ) {
            return await callApi( DELETE, `/api/${apiEndpoint}/${id}` );
        },
        ...additionalApis
    };

    return api;
}

async function callApi( type, url, payload = null ) {
    let response = {};

    try {
        switch ( type ) {
            case GET:
                response = await axios.get( url );
                break;
            case PATCH:
                response = await axios.patch( url, payload );
                break;
            case POST:
                response = await axios.post( url, payload );
                break;
            case DELETE:
                response = await axios.delete( url );
                break;
            default:
                throw 'unhandled api method';
        }

        response.success = true;
    }
    catch ( e ) {
        response.success = false;
        response.statusCode = e.response.status;
        response.message = e.response ? e.response.data ? e.response.data.message
            : e.response.statusText
            : e.message ;
        console.log( e );
    }

    let responseFormatted = {
        data: response.data ? response.data.data : null,
        success: response.success,
        message: response.message
    };

    if ( !responseFormatted.success && response.statusCode !== 404 ) {
        alert( 'Error executing API. Cause: ' + response.message );
    }

    return responseFormatted;
}