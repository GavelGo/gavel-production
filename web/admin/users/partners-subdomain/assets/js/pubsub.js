/**
* calculate and format time remaining on a coupon or auction
*
* Arguments:
*     notifications: json string of notification data
*/
function formatNotificationDateTimes(notifications) {
    var notificationCount = Object.keys(notifications).length;
    
    for (const key in notifications) {
        var notification = notifications[key];
        
        var now = new Date().getTime();
        var created = notification.created.split(/[- :]/);
        created = new Date(created[0], created[1]-1, created[2], created[3], created[4], created[5]).getTime();
        var distance = now - created;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        var timeDifference = '';
        if (days > 0) {
            timeDifference += days + " days";
        }
        else if (hours > 0) {
            timeDifference += hours + " hour";
            if (hours > 1) {
                timeDifference += "s";
            }
        }
        else if (minutes > 0) {
            timeDifference += minutes + " minute";
            if (minutes > 1) {
                timeDifference += "s";
            }
        }
        else if (seconds > 0) {
            timeDifference += seconds + " second";
            if (seconds > 1) {
                timeDifference += "s";
            }
        }

        notifications[key].timeDifference = timeDifference;
    }
    return notifications;
}

/**
*
*/
function prependNotificationDropdown(notification, userId, elementId) {
    var isRead = 0
    var backgroundColor = ""
    var textColor = ""
    if (notification.is_read == 0) {
        backgroundColor = "bg-secondary"
        textColor = "text-white"
    }

    $('#' + elementId).append("\
       <div class=\"notification " + backgroundColor + "\" onclick=\"followNotificationLink(\'" + notification.link + "\', " + notification.notification_id + ", " + userId + ", " + isRead + "); \">\
                <div class=\"alert\">\
                    <i class=\"fas fa-pen\"></i>\
                    <div class=\"alert-content " + textColor + "\">\
                            <span style=\"padding-left: 5px; class=\"alert-name\">" + notification.body + "</span>\
                    </div>\
                </div>\
            <div class=\"alert-time\">" + notification.timeDifference + "</div>\
        </div>"
    )
}

/**
*
*/
function saveNotificationStatus(notificationId, userId, isRead) {
    data = {
        notification_id: notificationId,
        user_id:         userId,
        is_read:         isRead,
        action:          "save_user_notification_status",
        model:           "notification"
    }

    doAjax("POST", "/partners-subdomain/api/api.php", data).done(function(response) {
        parsedJson = JSON.parse(response)

        if(parsedJson['result'] !== "success"){
            console.log("error no success result status");
        }
    }).fail(function(error) {
        // fuck
    }).always(function() {
        // smth
    });

    return false;
}

/**
* open a connection to the websocket endpoint 
* this connection in turn creates listeners for each subscription
* the user has
*
* Arguments:
*     endpoint: string, host and port
*     userId: id of the user connection
*     couponSubscriptions: json object of coupon ids subscribed to
*     auctionSubscriptions: json object of auction ids
*     providerSubscriptions: json object of partnerIds
*     notificationElement: the top html element in the notification tab
*     messageElement: the top html element in the messages tab
*/
function connectUser(endpoint, 
                     userId, 
                     couponSubscriptions, 
                     auctionSubscriptions, 
                     partnerSubscriptions, 
                     notificationElement,
                     messageElement) {

    // console.log(partnerSubscriptions);

    var con = new ab.Session(endpoint, function() {
            // coupons subscriptions
            // element id will be notification tab of menu bar
            Object.values(couponSubscriptions).forEach(topic => {
                subscribeToCoupon(con, topic['hash'], userId, notificationElement);  
            });

            // auction subscriptions
            Object.values(auctionSubscriptions).forEach(topic => {
                subscribeToAuction(con, topic['hash'], userId, notificationElement);  
            });

            // provider subscriptions
            Object.values(partnerSubscriptions).forEach(topic => {
                subscribeToPartner(con, topic['hash'], userId, notificationElement);  
            });
        },
        function() {
            // change k?
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
}

/**
* listen for new auctions
*/
function subscribeToAuction(conn, id, userId, elementId) {
    conn.subscribe(id, function (category, data) {
    });
}

/**
* listen for new coupons
*/
function subscribeToCoupon(conn, id, userId, elementId) {
    conn.subscribe(id, function (category, data) {
    });
}

/**
* listen for all activity by a specific provider
*/
function subscribeToPartner(conn, topicHash, userId, elementId) {
    conn.subscribe(topicHash, function (category, data) {
        // associate user with this notification
        saveNotificationStatus(data.notification_id, userId, 0);

        prependNotificationDropdown(data, userId, elementId);
    });
}

/**
*
*/
function followNotificationLink(link, notificationId, userId, isRead) {
    // update read status
    if (isRead == 0) {
        data = {
            notification_id: notificationId,
            user_id:         userId,
            action:          "set_notification_as_read",
            model:           "notification"
        }
        response = doAjax("POST", "/partners-subdomain/api/api.php", data).done(function(response) {
            parsedResponse = JSON.parse(response)
            parsedResponse = JSON.parse(response)
            if(parsedResponse['result'] !== "success"){
                alert("Could not save notification due to server error. Please contact us regarding this issue.");
            }
        });
    }

    window.location = link;
}
