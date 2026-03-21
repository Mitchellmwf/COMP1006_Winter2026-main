I can't seem to get files to write/save to the server. I've tried move_uploaded_file(), fwrite, and even ftp connecting
Code works locally and has no issues unless on lamp server.
Could there be missing file write permissions?


# What is the purpose of the $_FILES superglobal in PHP? 
- Lets you access files uploaded via a form with method='post', held in an array

# Why does a form need special settings to upload files? 
- Form requires enctype="multipart/form-data" attribute to allow the uploading of files

# What function is used to move uploaded files to a folder? 
- move_uploaded_file() is used to move uploaded files

# Why is it important to control where uploaded files are stored? 
- Data is organized and is more secure