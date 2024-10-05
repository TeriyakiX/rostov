import axios from 'axios';

export default (Vue) => {
    axios.defaults.headers.common = {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    axios.interceptors.response.use(response => {
        return Promise.resolve(response);
    }, async error => {
        if (error.response) {
            switch (error.response.status) {
                case 500:
                    Vue.$toast.error(error.response.data.message);
                    // axios.post('/log', {
                    //     code: error.response.status,
                    //     stack: error.response.data,
                    //     message: error.response.data.message
                    // });
                    break;
                case 403:
                    Vue.$toast.error('You do not have permissions to do this action.');
                    break;
                case 409:
                    Vue.$toast.error(error.response.data.message);
                    // axios.post('/log', {
                    //     code: error.response.status,
                    //     stack: error.response.data,
                    //     message: error.response.data.message
                    // });
                    break;
                case 422:
                    break;
                case 419:
                    await refreshCSRFToken();
                    Vue.$toast.error('Ваша сессия истекла, попробуйте ещё раз.');
                    break;
                default:
                    Vue.$toast.error(error.response.status + ': ' + error.response.data.message);
                    // axios.post('/log', {
                    //     code: error.response.status,
                    //     stack: error.response.data,
                    //     message: error.response.data.message
                    // });
            }
        } else {
            Vue.$toast.error('Something went wrong. Try again later.');
            // axios.post('/log', {
            //     code: null,
            //     stack: error,
            //     message: 'Error'
            // });
        }
        return Promise.reject(error);
    });

    window.axios = axios;
}

const refreshCSRFToken = async () => {
    await axios.get('/')
        .then(({ data }) => {
            const wrapper = document.createElement('div');
            wrapper.innerHTML = data;
            return wrapper.querySelector('meta[name=csrf-token]').getAttribute('content');
        })
        .then((token) => {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            document.querySelector('meta[name=csrf-token]').setAttribute('content', token);
        });
}
