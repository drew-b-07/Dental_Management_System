function logout() {
    if(confirm("Are you sure you want to logout?")) {
        location.href = "../../dashboard_user/user/authentication_user/user-class.php?user_signout";
    }
}