/**
 * Fetches global app data used widely in the application
 * @param context
 * @returns {Promise<any>}
 */
export function getAppData(context) {
    return new Promise((resolve, reject) => {
        window.axios.get("/api/app/data").then((res) => {
            context.commit("setAppData", res);
            resolve(res);
        }, (err) => {
            reject(err);
        })
    });
}

