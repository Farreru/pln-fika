$(document).ready(function () {
    const url = 'http://localhost/pln/function.php?action=check_session';

fetch(url)
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.text();
})
.then(data => {
    const currentPage = window.location.href;
    if (data === "Session check failed") {
        if(!currentPage.includes('/pln/?login')){
            window.location.href = '/pln/?login';
        }
    }else if(data === "Session check success"){
        if(currentPage.includes('/pln/?login')){
            window.location.href = '/pln/?page=dashboard';
        }
        return true;
    } 
    
})
.catch(error => {
    console.error('There was a problem with the fetch operation:', error);
});
    });
    