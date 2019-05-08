<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hello World</title>
</head>
<body>
<h1>Test</h1>
<p>Fire Store Test Page</p>
</body>
</html>

<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>

<script>
     var config = {
		apiKey: "AIzaSyDGARCzf3aBljo0OkL8OMtMHWszuC3JNyI",
		authDomain: "asta-e633a.firebaseapp.com",
		databaseURL: "https://asta-e633a.firebaseio.com",
		projectId: "asta-e633a",
		storageBucket: "asta-e633a.appspot.com",
		messagingSenderId: "522123092307"
	};
	
	firebase.initializeApp(config);

    // Initialize Cloud Firestore through Firebase
    var db = firebase.firestore();
/*
    // get Data
    var docRef = db.collection("tb_device").doc("rVl9wHPbMJHyH31AlWPF");

    docRef.get().then(function(doc) {
        if (doc.exists) {
            console.log("Document data:", doc.data());
        } else {
            // doc.data() will be undefined in this case
            console.log("No such document!");
        }
    }).catch(function(error) {
        console.log("Error getting document:", error);
    });
*/
/*
	db.collection("tb_device").where("SerialNo", "==", "B827EB37D17F")
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            // doc.data() is never undefined for query doc snapshots
            console.log(doc.id, " => ", doc.data());
        });
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
*/
/*
    // realtime update
    db.collection("tb_device").where("SerialNo", "==", "test")
        .onSnapshot(function(doc) {
            console.log("Current data: ", doc.data());
       });


	db.collection("tb_device").where("SerialNo", "==", "test")
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            // doc.data() is never undefined for query doc snapshots
            console.log(doc.id, " => ", doc.data());
        });
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
*/
	db.collection("tb_device").where("SerialNo", "==", "B827EB37D17F")
    .onSnapshot(function(querySnapshot) {
        var cities = [];
        querySnapshot.forEach(function(doc) {
			console.log(doc);
            cities.push(doc.data().MACAddr);
			cities.push(doc.data().SerialNo);
			cities.push(doc.data().org_code);
        });
        console.log("Current cities in CA: ", cities.join(", "));
    });
/*
	db.collection("tb_device").get().then(function(querySnapshot) {
    querySnapshot.forEach(function(doc) {
        // doc.data() is never undefined for query doc snapshots
        //console.log(doc.id, " => ", doc.data());
		console.log(doc);
    });

});
*/
</script>