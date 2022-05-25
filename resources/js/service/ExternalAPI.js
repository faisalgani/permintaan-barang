import axios from 'axios';

export async function post(url, header, parameter){
    return await axios.post(url, JSON.stringify(parameter), {header})
        .then(res => {
            return res.data;
    });
}
export async function upload(url, header, parameter){
    return await axios.post(url, parameter, {header})
        .then(res => {
            return res.data;
    });
}

export async function get(url, header, parameter = {}){
    return await axios.get(url, {params: parameter}, {header})
        .then(res => {
            return res.data;
    });
}