insert into auth (uuid, email, password)
values (uuid_to_bin(:uuid), :email, :password);