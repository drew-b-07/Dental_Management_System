function logout() {
    if(confirm("Are you sure you want to logout?")) {
        location.href = "../../dashboard/admin/authentication/admin-class.php?admin_signout";
    }
}