import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const server_url = import.meta.env.VITE_API_BACKEND_URL;
async function saveUrl (url: string, subdir: string) {
    try {
        const response = await axios.post(import.meta.env.VITE_API_BACKEND_URL + '/api/shorten-url', { url, subdir });
        if (response.data.status === 'exist') {
            showToast("This URL is registered already."); 
        } else if (response.data.status === "error") {
            showToast("This URL is not safe over the network"); 
        } else {
            showToast("Success!");
        }
        return response.data;
    } catch (error) {
        showToast("An error occurred while connecting to the server"); 
        return {hash:'nohash'};
        // throw error; 
    }
}

function showToast( msg: string ) {
  toast( msg, { autoClose: 1000 }); 
};
export default saveUrl;