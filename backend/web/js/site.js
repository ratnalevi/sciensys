
var latestNotificationTime = 0;
var notificationInterval = 2000;
var notificationClearInterval = 1000;

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

    var notificationLoading = document.getElementsByClassName("notifications-loading");

    $.get("index.php?r=site/get-notifications&userId=" + userId)

        .done(function (notifications_all) {

                var nTitle = document.getElementsByClassName("notification-header");
                var nCount = document.getElementsByClassName("notification-count");
                var nList = document.getElementsByClassName("notification-list");
                var nFooter = document.getElementsByClassName("notification-footer");

                nList[0].innerHTML = '';

                if (nTitle == null || typeof nTitle == 'undefined') {
                    return;
                }
                if (nCount == null || typeof nCount == 'undefined') {
                    return;
                }
                if (nList == null || typeof nList == 'undefined') {
                    return;
                }

                if( notifications_all[0].length + notifications_all[1].length == 0 ){
                    nTitle[0].innerHTML = 'You have no notifications';
                    nFooter[0].setAttribute('style', 'display:none');
                    return;
                }

                for( var j = 0; j < 2; j++ ){
                    var notifications = notifications_all[j];
                    var notifCount = notifications.length ;
                    if( notifCount != 0 ){

                        nFooter[0].setAttribute('style', 'display:block');
                        if( j == 0 ) {
                            nCount[0].innerHTML = notifCount;
                            nTitle[0].innerHTML = 'You have ' + notifCount + ' new notifications';
                            latestNotificationTime = notifications[0].created_at;
                        }

                        for (var k = 0; k < notifCount; k++) {

                            var li = document.createElement("li");
                            if( j == 0 ){
                                li.style.cssText = 'background: grey;';
                            }
                            var a = document.createElement("a");
                            a.href = 'index.php?r=document-detail/index';
                            a.innerHTML = notifications[k].message;

                            var i = document.createElement("i");
                            i.className = 'fa fa-shopping-cart text-green';
                            i.setAttribute('class', 'fa fa-shopping-cart text-green');

                            a.appendChild(i);
                            li.appendChild(a);
                            nList[0].appendChild( li );
                        }
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

    var mask = document.getElementById('bg_mask');
    var layer = document.getElementById('frontlayer');
    if( mask !== null && typeof mask != 'undefined' ) {
        mask.style.visibility = 'visible';
        layer.style.visibility='visible';
    }

    getNotificationList();

    $('.notifications-menu').on('click', function(){

        if( latestNotificationTime > 0 ) {
            setTimeout("updateNotifications()", notificationClearInterval );
        }
    });
});
