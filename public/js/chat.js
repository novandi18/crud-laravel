var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl, {
        delay: {
            show: 500,
            hide: 0
        }
    });
});

// TANGGAL BAHASA INDONESIA
let bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

let tanggal = new Date().getDate();
let xbulan = new Date().getMonth();
let xtahun = new Date().getYear();

let bulan2 = bulan[xbulan];
let tahun2 = (xtahun < 1000) ? xtahun + 1900 : xtahun;
// END

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

localStorage.removeItem("navigation");
listChatAdmin();

function listChatAdmin() {
    localStorage.setItem("refresh", "listChat");
    $("#listChat").css({"display":"block"}).empty();
    $("#noChat").css({"display":"none"});
    document.getElementById("messages").innerHTML = "";

    $.ajax({
        type: 'GET',
        url: '/get_all_chat',
        dataType: 'json',
        success: function(data) {
            $("#titleChat").html("Chat");
            $("#refreshChat").removeClass("d-none");
            if("count" in data) {
                $("#listChat").css({"display":"none"}).empty();
                $("#noChat").css({"display":"block"});
                $("#countTitle").html('');
            } else {
                let currentMessage = [];
                let listName = [];
                for(let i = data.length - 1; i >= 0; i--) {
                    // Mendapatkan data 'message' yang berkaitan dengan user yang sedang login
                    let dataChat = {};
                    // Mendapatkan nama admin yang nge-chat
                    let dataName = {};
                    if(data[i].sender == data[i].login_username || data[i].receiver == data[i].login_username) {
                        dataChat.from_name = data[i].from_name;
                        dataChat.to_name = data[i].to_name;
                        dataChat.sender = data[i].sender;
                        dataChat.receiver = data[i].receiver;
                        dataChat.message = data[i].message;
                        dataChat.sent_at = data[i].sent_at;
                        dataChat.login_username = data[i].login_username;
                        currentMessage.push(dataChat);
                            
                        if(data[i].sender == data[i].login_username) {
                            dataName.name = data[i].to_name;
                            listName.push(dataName);
                        } else {
                            dataName.name = data[i].from_name;
                            listName.push(dataName);
                        }
                    }
                }
                    
                // Menghapus duplikasi data
                let dpName = new Set();
                const finalName = listName.filter(el => {
                    const duplicate = dpName.has(el.name);
                    dpName.add(el.name);
                    return !duplicate;
                });
                
                let dpMessage = new Set();
                const finalMessage = currentMessage.filter(el => {
                    const duplicate = dpMessage.has(el.to_name);
                    dpMessage.add(el.to_name);
                    return !duplicate;
                });
                
                let chatdata = finalMessage[0].sender + " : " + finalMessage[0].message;

                for(let i = 0; i < finalName.length; i++) {
                    if(finalMessage[i].sender == finalMessage[i].login_username) {
                        document.getElementById("listChat").innerHTML += "<li class='list-group-item d-flex align-items-center btn btn-light rounded-0 border' data-name='" + finalMessage[i].to_name + "' data-username='" + ((finalMessage[i].sender == finalMessage[i].login_username) ? finalMessage[i].receiver : finalMessage[i].sender) + "' data-navigation='listChat'  onclick='readChat(this)'><img src='' width='30px' class='rounded-circle'id='imgAdminChat"+ i +"'><div class='row d-flex' style='margin-left: .1em'><div class='d-flex align-items-center justify-content-between'><span style='font-weight: bold; text-overflow:ellipsis; white-space: nowrap; width: 13em; overflow: hidden;' class='text-dark text-start'>"+ finalName[i].name +"</span><span class='text-secondary' style='font-size: .7em'>"+ finalMessage[i].sent_at +"</span></div><span class='text-dark text-start' style='font-size: .8em; text-overflow: ellipsis; white-space:nowrap; width: 17em; overflow: hidden;'>"+ "You: " + finalMessage[i].message +"</span></div></li>";
            
                        $("#imgAdminChat" + i).attr("src", "/img/admin/" + finalMessage[i].receiver + ".png");
                    } else {
                        document.getElementById("listChat").innerHTML += "<li class='list-group-item d-flex align-items-center btn btn-light rounded-0 border' data-name='" + finalMessage[i].to_name + "' data-username='" + ((finalMessage[i].sender == finalMessage[i].login_username) ? finalMessage[i].receiver : finalMessage[i].sender) + "' onclick='readChat(this)'><img src='' width='30px' class='rounded-circle'id='imgAdminChat"+ i +"'><div class='row d-flex' style='margin-left: .1em'><div class='d-flex align-items-center justify-content-between'><span style='font-weight: bold; text-overflow:ellipsis; white-space: nowrap; width: 13em; overflow: hidden;' class='text-dark text-start'>"+ finalName[i].name +"</span><span class='text-secondary' style='font-size: .7em'>"+ finalMessage[i].sent_at +"</span></div><span class='text-dark text-start' style='font-size: .8em; text-overflow: ellipsis; white-space:nowrap; width: 17em; overflow: hidden;'>"+ finalMessage[i].message +"</span></div></li>";
                    
                        $("#imgAdminChat" + i).attr("src", "/img/admin/" + finalMessage[i].sender + ".png");
                    }
        
                    // Hitung berapa orang yang nge-chat
                    $("#countTitle").html(finalName.length);
                }
            }
        }
    });
}

function readChat(data) {
    $("#noChat").css({"display":"none"});
    $("#listChat").css({"display":"none"});
    chatAdmin(data);
}

function getAdminContact() {
    localStorage.setItem("refresh", "kontakAdmin");

    $.ajax({
        type: 'GET',
        url: '/get_all_admin',
        dataType: 'json',
        success: function(data) {
            if(data == 1 || data == 0) {
                document.getElementById("listAdmin").innerHTML = "<div class='d-flex h-100 justify-content-center align-items-center flex-column px-5 text-secondary' style='margin-top: -1em'><i class='bi bi-people' style='font-size: 4em'></i><span class='text-center'>Tidak ada kontak admin</span></div>";
            } else {
                $("#listAdmin").empty();
                data.forEach((e, i) => {
                    document.getElementById("listAdmin").innerHTML += "<li class='list-group-item d-flex align-items-center rounded-0 border'><img src='' width='30px' class='rounded-circle' id='imgAdmin" + i + "'><div class='d-flex justify-content-between'><div class='d-flex flex-column' style='margin-left: .6em'><span style='font-weight: bold; text-overflow: ellipsis; white-space: nowrap; width: 10em; overflow: hidden;' class='text-dark text-start' id='namaAdmin'>"+ e.name +"</span><span class='text-dark text-start' style='font-size: .8em; text-overflow: ellipsis; white-space: nowrap; width: 20em;overflow: hidden;' id='usernameAdmin'>"+ e.username +"</span></div><button data-username='" + e.username + "' data-name='"+ e.name +"' class='btn btn-primary text-white rounded-circle' data-navigation='kontakAdmin' style='margin-left: -3em;' onclick='chatAdmin(this)'><i class='bi bi-chat-right-text-fill'></i></button></div></li>";
    
                    $("#imgAdmin" + i).attr("src", "/" + e.image);
                });
    
                // Hitung jumlah kontak admin
                $("#countTitle").html(data.length);
            }
        }
    });
}

$("#chat").on('hide.bs.dropdown', (e) => {
    if(e.clickEvent) {
        e.preventDefault();
    }
});

$("#chatHide").click(() => {
    $("#dropdownHide").dropdown('toggle');
});

$("#chatContact").click(() => {
    $("#titleChat").html("Kontak Admin");
    getAdminContact();
    $("#noChat").css({"display":"none"});
    $("#listAdmin").css({"display":"block"});
    $("#chatContact").css({"display":"none"});
    $("#chatList").css({"display":"block"});
    $("#listChat").css({"display":"none"});
});

$("#chatList").click(() => {
    $("#titleChat").html("Chat");
    $("#noChat").css({"display":"block"});
    $("#listAdmin").css({"display":"none"});
    $("#chatContact").css({"display":"block"});
    $("#chatList").css({"display":"none"});
    listChatAdmin();
});

$("#btnChatStart").click(() => {
    $("#titleChat").html("Kontak Admin");
    $("#noChat").css({"display":"none"});
    $("#listAdmin").css({"display":"block"});
    $("#chatContact").css({"display":"none"});
    $("#chatList").css({"display":"block"});
});

$("#chatBack").click(() => {
    $("#chatBack").css({"display":"none"});
    $("#refreshChat").removeClass("d-none");
    if(localStorage.getItem('navigation') == 'kontakAdmin') {
        $("#titleChat").html("Kontak Admin");
        $("#personalChat").css({"display":"none"});
        $("#listAdmin").css({"display":"block"});
        getAdminContact();
        $("#chatList").css({"display":"block"});
        $("#chatContact").css({"display":"none"});
    } else if(localStorage.getItem('navigation') == 'listChat') {
        $("#titleChat").html("Chat");
        $("#personalChat").css({"display":"none"});
        $("#listChat").css({"display":"block"});
        listChatAdmin();
        $("#chatList").css({"display":"none"});
        $("#chatContact").css({"display":"block"});
    } else {
        $("#titleChat").html("Chat");
        $("#personalChat").css({"display":"none"});
        $("#listChat").css({"display":"block"});
        listChatAdmin();
        $("#chatList").css({"display":"none"});
        $("#chatContact").css({"display":"block"});
    }
});

function chatAdmin(data) {
    $("#listAdmin").css({"display":"none"});
    $("#personalChat").css({"display":"block"});
    $("#titleChat").html($(data).data('name'));
    $("#to_name").val($(data).data('name'));
    $("#imageAdminChat").attr("src", $(data).data('image'));
    $("#chatList").css({"display":"none"});
    $("#chatBack").css({"display":"block"});
    $("#chatContact").css({"display":"none"});
    $("#receiver").val($(data).data('username'));
    $("#countTitle").html("");
    $("#refreshChat").addClass("d-none");
    localStorage.setItem('navigation', $(data).data("navigation"));

    $.ajax({
        type: 'POST',
        url: '/get_chat_history',
        data: {
            username: $("#receiver").val()
        },
        success: function(data) {
            let tgl = tanggal + ' ' + bulan2 + ' ' + tahun2;
            let receiver = $("#receiver").val();
            const elm = document.getElementById("messages");
            let arr = [];
            let x = 0;

            for(let i = 0; i < data.length; i++) {
                if(data[i].sender == receiver || data[i].receiver == receiver) {
                    if(data[i].sender == data[i].username_log || data[i].receiver == data[i].username_log) {
                        arr.push(data[i].chat_date);
                        x += 1;
    
                        if((x - 1) == 0) {
                            elm.innerHTML += "<div id='chat-date' class='w-100 bg-light p-2 text-secondary text-center mb-2 rounded' style='font-size: .7em;'>" + ((arr[x - 1] == tgl) ? "Hari ini" : arr[x - 1] ) + "</div>";
                        } else if(arr[x - 1] != arr[x - 2]) {
                            elm.innerHTML += "<div id='chat-date' class='w-100 bg-light p-2 text-secondary text-center my-2 rounded' style='font-size: .7em;'>" + ((arr[x - 1] == tgl) ? "Hari ini" : arr[x - 1] ) + "</div>";
                        }
                        
                        if(data[i].sender == receiver) {
                            elm.innerHTML += "<div class='d-flex align-items-center justify-content-between w-100 pt-1 pb-1'><span style='font-size: .9em' class='bg-primary text-white px-2 py-1 rounded'>" + data[i].message + "</span><span class='text-secondary' style='font-size: .7em'>" + data[i].sent_at + "</span></div>";
                        } else {
                            elm.innerHTML += "<div class='d-flex justify-content-between align-items-center w-100 pt-1 pb-1' id='auth'><span class='text-secondary' style='font-size: .7em'>" + data[i].sent_at + "</span><span style='margin-left: .5em; font-size: .9em' class='bg-secondary text-white px-2 py-1 rounded'>" + data[i].message + "</span></div>";
                        }
                    }
                }
            }
        }
    });
}

function refresh() {
    if(localStorage.getItem('refresh') == 'kontakAdmin') {
        getAdminContact();
    } else if(localStorage.getItem('refresh') == 'listChat') {
        listChatAdmin();
    }
}