// Logout confirmation function
function confirmLogout() {
    Swal.fire({
        icon: 'question',
        title: 'ยืนยันการออกจากระบบ',
        text: 'คุณต้องการออกจากระบบหรือไม่?',
        showCancelButton: true,
        confirmButtonText: 'ใช่ ออกจากระบบ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout router
            window.location.href = '/Next_Gen/router/logout.router.php';
        }
    });
}
