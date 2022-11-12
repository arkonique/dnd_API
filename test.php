<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<script>
    async function postData(url = '', data = {}) {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });
    return response.json();
  }


  // get list of users
  fetch('http://localhost/dnd_api/index.php/user/list').then((data) => {
    return (data.json()); // JSON data parsed by `data.json()` call
  }).then(post => {console.log(post)});
  
  //get one user
  postData('http://localhost/dnd_api/index.php/user/salt',{
    u: "rm",
  }).then((data) => {
    console.log(data); // JSON data parsed by `data.json()` call
  });
  
  /*
  
  
  ////////// WARNING /////////////////////// This will blow up your table so just be careful
  
  postData('http://localhost/dnd_api/index.php/user/add',{data:['aaa','abfg234','AAA battery','bej34erkjvs48kjd932','AF321','abcdefghij']}).then((data) => {
    console.log(data); // JSON data parsed by `data.json()` call
  });
  
  
  postData('http://localhost/dnd_api/index.php/user/bits').then((data) => {
    console.log(data); // JSON data parsed by `data.json()` call
  });
  
  */
</script>
</body>
</html>