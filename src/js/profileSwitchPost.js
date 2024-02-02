document.getElementById('postButton').addEventListener('click', function() {
    document.getElementById('postSection').style.display = 'block';
    document.getElementById('tagSection').style.display = 'none';
    document.getElementById('savedSection').style.display = 'none';
});

document.getElementById('tagButton').addEventListener('click', function() {
    document.getElementById('postSection').style.display = 'none';
    document.getElementById('tagSection').style.display = 'block';
    document.getElementById('savedSection').style.display = 'none';
});

document.getElementById('savedButton').addEventListener('click', function() {
    document.getElementById('postSection').style.display = 'none';
    document.getElementById('tagSection').style.display = 'none';
    document.getElementById('savedSection').style.display = 'block';
});
