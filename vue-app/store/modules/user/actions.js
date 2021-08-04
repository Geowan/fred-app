/**
 * Fetches global app data used widely in the application
 * @param context
 * @returns {Promise<any>}
 */
export function getActiveUser(context) {
    return new Promise((resolve, reject) => {

        context.commit("setLoggedinStatus", false);

        window.axios.get("/api/auth/active-user").then((res) => {
            context.commit("setData", res);
            context.commit("setLoggedinStatus", true);
            resolve(res);
        }, (err) => {
            context.commit("setLoggedinStatus", false);
            reject(err);
        })
    });
}

