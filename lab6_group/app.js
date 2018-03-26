var express = require ('express');
var    app = express();
var    server = require('http').createServer(app);
 var   io = require('socket.io').listen(server);
  var  users = {};
     
  var  defaultroom = 'defaultroom';
var mongoose = require ('mongoose');
    mongoose.set('debug', true);
// var autoIncrement = require('mongoose-auto-increment'); 
server.listen(3456);
var Schema = mongoose.Schema;
var autoIncrement = require('mongoose-auto-increment');
var url = 'mongodb://localhost/chat';
var connection = mongoose.createConnection(url);
var db = mongoose.connection;
var roomlist = [];
var securelist = [];
var securepasslist = [];

autoIncrement.initialize(connection);
app.use(express.static('static'));
//how to connect to mongodb 
//mongoose.connect('mongodb://localhost/mod/myapp/chat', function (err) {
//    if(err){
//        console.log(err);
//        
//    }
//    else {
//       
//        console.log('connect to databse successfully');
//    }
//} );
//create a schema to store chat contents
var chatSchema2 = new Schema({
    chatid : Number,
    username: String,
    msg: String,
    created: {type: Date, default: Date.now}
});
var messageSchema = new Schema({
    chatid: Number,
    username: String,
    roomname: String,
    msg: String,
    created: Date
});
// Add the date before any save
messageSchema.pre('save', function(next) {
    // get the current date
    var currentDate = new Date();
    // change the updated_at field to current date
    // this.updated_at = currentDate;
    // if created_at doesn't exist, add to that field
    if (!this.created){
        this.created = currentDate;
        next();
    }
});
messageSchema.plugin(autoIncrement.plugin, {
  model: 'Message',
  field: 'message_id',
  startAt: 1,
  incrementBy: 1
});
//var chatSchema = new 
//trying to create a schema to store username and password 
var userSchema = new Schema({
    userid : Number,
    username: { type: String, required: true, unique: true},
    password: {type: String, required: true},
    q1: String,
    q1ans: String,
    created_at: Date,
    updated_at: Date,
    lat : Number,
    lng : Number,
    loc:{type: [Number], index: "2dsphere"}
});
chatSchema2.pre('save', function(next) {
    var currentDate = new Date();
    // change the updated_at field to current date
    this.updated_at = currentDate;
    // if created_at doesn't exist, add to that field
    if (!this.created_at){
        this.created_at = currentDate;
        next();
    }
});
// get the current date
userSchema.pre('save', function(next) {
    // get the current date
    var currentDate = new Date();
    // change the updated_at field to current date
    this.updated_at = currentDate;
    // if created_at doesn't exist, add to that field
    if (!this.created_at){
        this.created_at = currentDate;
        next();
    }
});
chatSchema2.plugin(autoIncrement.plugin, {
    model: 'Chat',
    field: 'chatid',
    startAt: 1,
    incrementBy: 1
});
userSchema.plugin(autoIncrement.plugin, {
    model: 'User',
    field: 'userid',
    startAt: 1,
    incrementBy: 1
});
var User = connection.model('User', userSchema);
//create a collection 'Messages'
//collection name, collection schema 
var Chat = mongoose.model('Chat', chatSchema2);
var Message = connection.model('Message', messageSchema);
//express will send index.html to guest whenver accesses. 
app.get('/', function(req, res){
  res.sendFile(__dirname + '/index2.html');
});
userSchema.index({loc: '2dsphere'});
//mongoose.connection.ensureIndex({loc: "2dsphere"});
io.sockets.on('connection', function (socket) {
    //I connect user to default room when connect 
    socket.join(defaultroom);
    socket.room = defaultroom;
    // this is a query to fetch message from the database, 
    var query = Message.find({roomname: socket.room});
    query.sort('-created').limit(8).exec(function(err, docs){
        if (err){
            throw err;
        }
        socket.emit('load old msgs', docs);
    });
    // what to do when the user click leave new room button
    socket.on('leave new room', function(data, callback){
        var currentusername = data.username;
        socket.leave( data.roomname);
        callback(defaultroom);
        socket.join(defaultroom);
        socket.room = defaultroom;
        var query = Message.find({roomname: socket.room});
        query.sort('-created').limit(8).exec(function(err, docs){
            if (err){
                throw err;
            }
            io.to(defaultroom).emit('load old msgs', docs);  
        });
        users[socket.username]= socket;
        updateUsernames();
    });
    // what to do if user want to join a existing room
    socket.on ('joinroom', function(data, callback){
        delete users[socket.username];
        //after joining new room, update userlist in the defaultroom
        io.to(defaultroom).emit('usernames', Object.keys(users)); 
        var joinroomuser = data.username;
        var joinroomname = data.roomname;
        console.log("the user that is trying to join room is "+ joinroomuser);
        console.log("the room trying to join is "+roomlist[joinroomname]);
        if (roomlist[joinroomname]!== undefined && roomlist[joinroomname].blacklist[joinroomuser]=== undefined){
            socket.leave(defaultroom);
            socket.join(joinroomname);
            socket.room = joinroomname;
            callback(joinroomname);
            console.log(roomlist[joinroomname]);
            (roomlist[joinroomname].userlist)[joinroomuser] = socket;
            // ok I want to update usernamelist from this new room 
            io.to(joinroomname).emit('usernames', Object.keys( roomlist[joinroomname].userlist));
            // now display chat history from this room 
            var query = Message.find({roomname: socket.room});
            query.sort('-created').limit(8).exec(function(err, docs){
                if (err){
                    throw err;
                }
                io.to(joinroomname).emit('load old msgs', docs);
            });  
        }
        else {
            callback("error");
        }
    });
    
    //join a secure room
     socket.on ('joinsroom', function(data, callback){
        
          delete users[socket.username];
        //after joining new room, update userlist in the defaultroom
        io.to(defaultroom).emit('usernames', Object.keys(users));
        var joinroomuser = data.username;
        var joinroompass = data.pass;
        var joinroomname = data.roomname;
        if(securelist[joinroomname]!== undefined && securelist[joinroomname].pass === joinroompass){
            
             socket.leave(defaultroom);
            socket.join(joinroomname);
            socket.room = joinroomname;
            callback(joinroomname);
           ( securelist[joinroomname].userlist)[joinroomuser] = socket;
           // ok I want to update usernamelist from this new room 
            io.to(joinroomname).emit('usernames', Object.keys( securelist[joinroomname].userlist));
           
        }
        
        
        
        
        
     });
    
    //create a new secure room 
    socket.on('newsroom', function(data, callback){
       delete users[socket.username];
       io.to(defaultroom).emit('usernames', Object.keys(users)); 
         var owner = data.owner;
             var roomName = data.newroomName;
             console.log("secure room name is "+ roomName);
             var roompass = data.newroompass;
              var newuserlist = {};
               socket.leave(defaultroom);
        socket.join(roomName);
        socket.room = roomName;
         newuserlist[socket.username]=socket;
      
            var secureroom = {name: roomName, pass: roompass, owner: owner, userlist: newuserlist };
            securelist[roomName]= secureroom;
             io.to(roomName).emit('usernames', Object.keys(secureroom.userlist));
             callback(roomName);
    });
    
    
    
    
    //what to do if user want to create a new room 
    socket.on('newroom', function(data, callback){
        delete users[socket.username];
        //after a new room, I have to send message to the default room to clear up the user list 
        io.to(defaultroom).emit('usernames', Object.keys(users)); 
        var owner = data.owner;
        var roomName = data.newroomName;
        var newuserlist = {};
        var blacklist = {};
        socket.leave(defaultroom);
        socket.join(roomName);
        socket.room = roomName;
        newuserlist[socket.username]=socket;
        var room = {name: roomName, owner: owner, userlist: newuserlist, blacklist: blacklist};
        roomlist[roomName]=room;
        //  newrooms[roomName]= socket;
        // ok I want to update usernamelist from this new room , I send the update username command to the specific new room name 
        io.to(roomName).emit('usernames', Object.keys(room.userlist));
        //  console.log("the room list I want is "+room)
        // in the defaultroom ,   i WANT TO update the room list because I just created a room 
        io.to(defaultroom).emit('updaterooms', Object.keys(roomlist));
        io.to(roomName).emit('updaterooms', Object.keys(roomlist));
        callback(roomName);
        // now display chat history from this room 
        var query = Message.find({roomname: socket.room});
        query.sort('-created').limit(8).exec(function(err, docs){
            if (err){
                throw err;
            }
            io.to(roomName).emit('load old msgs', docs);
        });  
    });
    socket.on('recoverUser', function(data, callback){
        console.log(data);
        User.findOne({ username: data}, function (err, user) {
            if (user === null) {
                // socket.emit('exception', {message: 'This user is not exist. Please create your account !'});
                callback(null);
                console.log("username does not exist ");  
            }else{
                console.log("your username exist, trying to fetch Q1 and ans");
                console.log("your q1 is "+user.q1);
                callback(user.q1);
            }
        });
    });
    socket.on('recoverUserAns', function(data, callback){
        User.findOne( { q1: data.q1, q1ans: data.q1Ans }, function (err, user) {
            if (user === null) {
                console.log(" the q1 being tested is "+data.q1+" the ans get is " + data.q1Ans);
                callback(false);
                console.log("pwd reset q wrong  ");
            }else{
                callback(true);
            }
        });
    });
    socket.on('ban user', function(data){
        var baduser = data.baduser;
        var currentroom = data.currentroom;
        console.log("blacklist is "+ roomlist[currentroom].blacklist);
        
        roomlist[currentroom].blacklist[baduser]=baduser;
        //  socket.room.blacklist[baduser]= baduser;
        // console.log(socket.room.blacklist);
        //console.log("success");
    });
    socket.on('get near users', function(data, callback){
        var crtuser = data;
        User.findOne({ username: crtuser }, function (err, user) {
            if (user.lat !== null && user.lng !== null){
                var crtlat = user.lat;
                var crtlng = user.lng;
                console.log("crt user lat found it is "+ crtlat);
                //  var query = Message.find({roomname: socket.room});
                //var query =  User.geoNear({type: "Point", coordinates: [crtlat,crtlng]},{
                //    spherical:true,
                //    maxDistance: 10
                //    
                //    
                //  });
                //query.exec(function(err,docs){
                //    if(err) throw err;
                //    console.log("hahaha");
                //    console.log(docs);
                //    callback(true);
                //    
                //});
                //var searchoptions = {
                //    sperical:true,
                //    maxDistance:10
                //    
                //    
                //    };
                //    
                //    var location = {
                //        
                //        type : "Point",
                //     coordinates: [crtlat,crtlng]
                //    };
                //    
                //    User.geoNear(location, searchoptions, function(err, results){
                //        
                //        
                //        console.log("success  "+ results);
                //    });
                var query = User.find({
                    lat:{   $gt: crtlat-5, $lt: crtlat+5},
                    lng:{   $gt: crtlng-5, $lt: crtlng+5}
                });
                query.select('username');
                query.exec(function(err, data){
                    user.save(function(err){
                        if (err)throw err;
                    });
                    console.log(data);
                    socket.emit('handle near users', data);
                });
                //User.find({
                //    
                //    lat:{   $gt: crtlat-5, $lt: crtlat+5},
                //    lng:{   $gt: crtlng-5, $lt: crtlng+5}
                //    
                //}, function(err, data){
                //    if  (err) throw err;
                //    
                //    console.log("success find" + data);
                //    socket.emit
                //});
            }
        });
        //    User.geoNear({type: "Point", coordinates: [crtlat,crtlng]},{
        //      spherical:true,
        //      maxDistance: 10
        //     
        //      
        //    })
        //    .then(function(doc){
        //      
        //      console.log("Execte query complet!!!!!!!!!!!!!!!!!!");
        //      console.log(doc);
        //    //  callback(true);
        //    //  
        //    //  
        //    //});
        //  }
        //  
        //});
    });
    socket.on('geo coordinates', function(data){
        var lat = data.lat;
        var lng = data.lng;
        console.log("the lat is "+lat);
        console.log("the lng is "+lng);
        for (var i =0;i<roomlist.length;i++){
            console.log("roomlist owner is "+roomlist[i].owner); 
        }
        if (socket.username !== null){
            User.findOne({ username: socket.username }, function (err, user) {
                if (user !== null) {
                    user.lat = lat;
                    user.lng = lng;
                    user.loc = [lat,lng];
                    console.log("trying to save coor");
                    //Thanks to Reis Sirdas for helping with this error!
                    user.save(function(err){
                        if (err)throw err;
                    });
                }else{
                    console.log("socket user name is null, error");
                }
                console.log("save coor complete");
            });
        }
        else{
            console.log("socket user name is null, error");
        }
    });
    socket.on('resetPassword', function(data, callback){
        var query = {username : data.username};
        User.findOneAndUpdate(query, {password : data.newpass}, callback);
        callback(true);
        //
        //User.findOne({ username: data.username }, function (err, user) {
        //  console.log(user);
        //    console.log("the previous password is "+user.password);
        //    
        //    user.password = data.newpass;
        //    console.log("after saved pass is "+user.password);
        //    console.log(user);
        //    user.save(function (err) {
        //        console.log(err);
        //        if(err === null){
        //    
        //        
        //        //if (err) throw err;
        //     console.log("the new password is"+user.password);
        //        callback(true);}
        //    });
        //});
    });
    socket.on('login', function (data, callback) {
        User.findOne({ username: data.username }, function (err, user) {
            if (user === null) {
              
                callback(false);
                console.log("username does not exist ");
            } else {
                User.findOne( { username: data.username, password: data.password }, function (err, user) {
                    if (user === null) {
                        //  socket.emit('exception', {message: 'Wrong password !'});
                        callback(false);
                        console.log("username exist, but pwd does not match ");
                    } else {
                    callback({username:user.username, roomname: socket.room});
                    //user.username is potentially wrong
                    console.log('User ' + user.username + ' is online');
                    // Add new user to store
                    console.log("user.username is "+user.username+ " but data.username is "+ data.username);
                    socket.username = data.username;
                    console.log("socket.username is "+ socket.username);
                    users[socket.username]= socket;
                    updateUsernames();
                
                    }
                });
            }
        });
    });
    
    
    // Listen for registr action
    socket.on('register', function (data, callback) {
        console.log('reg start');
        for (var a=0; a<data.username.length;a++){
            if ((data.username.substr(a) === "'" )|| (data.username.substr(a) === "/" ) || (data.username.substr(a) === ";") ||(data.username.substr(a) === "{") ||(data.username.substr(a) === "}" )){
                
            callback(false);
        }
      //  ' " \ ; { }
        }
        User.findOne({ username: data.username }, function (err, user) {
            if (user === null) {
              
                var newUser = new User({
                    username: data.username,
                    password: data.password,
                    q1: data.q1,
                    q1ans: data.q1ans
                });
                newUser.isNew = true;
                console.log(newUser);
                // Save user to database
                newUser.save(function (err) {
                    console.log(err);
                    if (err === null) {
                        // Make this user online
                        User.findOne({ username: data.username }, function (err, user) {
                            console.log('User ' + user.username + ' is online');
                            callback(true);
                            socket.username = data.username;
                            users[socket.username]= socket;
                            updateUsernames();
                   
                        });
                    }
                });
            } else {
            callback(false);
            //socket.emit('exception', {message: 'This user is already registered'});
            }
        });
    });
    function updateUsernames(){
        io.to(defaultroom).emit('usernames', Object.keys(users));
    }
    socket.on('base64 file', function (msg) {
        console.log('received base64 file from' + msg.username);
       // socket.username = msg.username;
        // socket.broadcast.emit('base64 image', //exclude sender
        io.sockets.emit('base64 file',  //include sender
            {
              username: socket.username,
              file: msg.file,
              fileName: msg.fileName
            }
        );
    });
    //send message 
    socket.on('send message', function(data, callback){
        var roomname = data.roomname;
        console.log("send message command received, starting to analyze message");
        var msg = data.message.trim();
        if (msg.substr(0,3) === '/w '){
            console.log("preparing to send private message ");
            msg = msg.substr(3);
            var ind = msg.indexOf(' ');
            if (ind !== -1){
                console.log('success');
                var name = msg.substring(0,ind);
                msg = msg.substring(ind+1);
                if (name in users){
                    users[name].emit('whisper', {msg: msg, username: socket.username});
                }
                else {
                    callback("error ! cannot whisper to a non valid user ");
                }
            }
            else {
                callback('error enter message plz'); 
            } 
        }else if (msg.substr(0,3) === '/k ' && roomlist[roomname].owner === socket.username){
            console.log("preparing to kick out ");
            msg = msg.substr(3);
            var ind2 = msg.indexOf(' ');
            if (ind2 !== -1){
                console.log('success');
                var name2 = msg.substring(0,ind2);
                var msg2 = msg.substring(ind2+1);
                if (name2 in roomlist[roomname].userlist){
                    roomlist[roomname].userlist[name2].emit('kicked out', {msg: msg, username: socket.username});
                }
                else {
                    callback("error ! cannot whisper to a non valid user ");
                }
            }
            else {
                callback('error enter message plz');     
            }
        }
        else{         
            console.log("starting to send new message. preparing for dataabse now ");
            //message now has a roomname
            //how to insert new mssage into mongodb 
            var message = new Message({username: socket.username, msg: msg, roomname: socket.room});
            console.log(message);
            message.save(function(err, message) {
                if (err) return console.error(err);
                console.log("the roomname trying to broadcastis "+data.roomname);
                io.to(data.roomname).emit('new message', {msg: msg, username: socket.username, roomname: socket.room});
            });
        }
        // socket.broadcast.emit('new message', data);
    });
    socket.on('disconnect', function(data){
        if (!socket.username)   return;
        delete users[socket.username];
        //nicknames.splice(nicknames.indexOf(socket.nickname), 1);
        updateUsernames();
    });
});