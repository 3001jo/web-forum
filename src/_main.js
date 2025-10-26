console.log("Source and License: https://github.com/3001jo/web-forum")
console.log("_main.js");

function delete_post(postID) {
	fetch(`api.php?action=delete_post&postID=${postID}`)
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response not ok: ' + response.statusText);
			}
			return response.json();
		})
		.then(data => {
			if (data['success']) {
				document.getElementById(`post_${postID}`).remove();
			}
		})
		.catch(error => {
			console.error('Error:', error);
		});
}
