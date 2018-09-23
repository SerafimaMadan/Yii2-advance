
var websocketPort = wsPort ? wsPort : 8080;
    conn = new WebSocket('ws://host1:' + websocketPort);
    idMessages = 'chatMessages';

    // console.log(conn);

conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onerror = function(e) {
    console.log("Connection fail!");
};
conn.onmessage = function(e) {
   // alert(e.data);
    document.getElementById(idMessages).value=e.data + '\n'+ document.getElementById(idMessages).value;
    console.log(e);
//усли выводить переменную e.data в console.log -  то чат работает только в консоли
};