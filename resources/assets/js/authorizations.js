let user = window.App.user;
let isSignedIn = window.App.signedIn;

export default {
    isAdmin() {
        return isSignedIn ? user.is_admin : false;
    }
}