conn=database('forged_authentication','root','');
curs=exec(conn,'select File_Name from certeficates WHERE ID=45');
curs=fetch(curs);
c=curs.Data
%C:\wamp\www\forged - Copy\uploads
image_folder='C:\wamp\www\forged - Copy\uploads'
%filename=
%filename=dir(fullfile(image_folder,'is.jpg'))
set()
f=fullfile(image_folder,filename.name);
%imgn=img.name
Image1 = imread(f);
%imshow(img)
%imshow
%img1=img.name
imshow(Image1)
