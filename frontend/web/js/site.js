
var latestNotificationTime = 0;
var notificationInterval = 1000;

function readCookie(name, type) {

    var cookies;
    if (cookies) {
        return cookies[name];
    }

    var c = document.cookie.split('; ');
    cookies = {};

    for (i = c.length - 1; i >= 0; i--) {
        var C = c[i].split('=');
        cookies[C[0]] = C[1];
    }

    var slug = cookies[name];
    if (typeof slug == 'undefined' || slug == '') {
        return null;
    }
    var slugParts;

    if (type == 'i') {
        slugParts = slug.split('i%3A');
    }
    else {
        slugParts = slug.split('s%3A');
    }
    slugParts = slugParts[slugParts.length - 1];

    var test = slugParts.split('%3A%22');

    slugParts = test.toString().split(',');

    slugParts = slugParts[slugParts.length - 1];

    slugParts = slugParts.split('%22');

    var result = slugParts[0];
    if (result.toString().indexOf("%3B") != 0) {
        result = result.toString().split("%3B%7D");
        result = result[0];
    }

    return result;
}

function getNotificationList() {

    var name = 'userId';
    var userId = readCookie(name, 'i');

    if (userId == null) {
        console.log('User details not found');
        return;
    }
        
    $.get("index.php?r=site/get-notifications&userId=" + userId)

        .done(function (notifications) {

                var nTitle = document.getElementsByClassName("notification-header");
                var nCount = document.getElementsByClassName("notification-count");
                var nList = document.getElementsByClassName("notification-list");
                var nFooter = document.getElementsByClassName("notification-footer");

                if (nTitle == null || typeof nTitle == 'undefined') {
                    return;
                }
                if (nCount == null || typeof nCount == 'undefined') {
                    return;
                }
                if (nList == null || typeof nList == 'undefined') {
                    return;
                }

                var notifCount = notifications.length ;
                if( notifCount == 0 ){
                    nTitle[0].innerHTML = 'You have no new notifications';
                    nFooter[0].setAttribute('style', 'display:none');
                }
                else {
                    latestNotificationTime = notifications[0].created_at;
                    nFooter[0].setAttribute('style', 'display:block');
                    nCount[0].innerHTML = notifCount;
                    nTitle[0].innerHTML = 'You have ' + notifCount + ' new notifications';

                    nList[0].innerHTML = '';
                    for (var k = 0; k < notifCount; k++) {

                        var li = document.createElement("li");
                        var a = document.createElement("a");
                        a.href = 'index.php?r=document-detail/view&id=' + notifications[k].document_id;
                        a.innerHTML = notifications[k].message;

                        var i = document.createElement("i");
                        i.className = 'fa fa-shopping-cart text-green';
                        i.setAttribute('class', 'fa fa-shopping-cart text-green');

                        a.appendChild(i);
                        li.appendChild(a);
                        nList[0].insertBefore(li, nList[0].childNodes[0]);
                    }
                }
            }
        );

    setTimeout("getNotificationList()", notificationInterval);
}

function updateNotifications(){
    var nTitle = document.getElementsByClassName("notification-header");
    var nCount = document.getElementsByClassName("notification-count");

    var name = 'userId';
    var userId = readCookie(name, 'i');

    if (userId == null) {
        console.log('User details not found');
        return;
    }

    $.get("index.php?r=site/update-notifications&userId=" + userId + '&lastSeen=' + latestNotificationTime)
        .done(function (result) {
                console.log(result);
                nCount[0].innerHTML = '';
                nTitle[0].innerHTML = 'You have no new notifications';
                latestNotificationTime = 0;
            }
        );
}

function loadModal( button ){

    var docUploadID = $('#doc_upload_type_id');

    $(".document-upload-form")[0].reset();

    var str = button.id;
    var parts = String(str).split('-');
    var id = Number( parts[0]);
    var name = parts[1];
    var divModal = $('#doc_upload');

    docUploadID.val(id);

    divModal.modal('show');
    divModal.modal({
        backdrop: 'static',
        keyboard: false
    })


}

$(document).ready(function(){
    getNotificationList();

    $('.notifications-menu').on('click', function(){

        if( latestNotificationTime > 0 ) {
            setTimeout("updateNotifications()", notificationInterval/5);
        }
    });
});
