delete from zf_reply WHERE (id >=2000000 AND id <= 3000000 ) AND NOT EXISTS (select 1 FROM zf_user b WHERE authorid = b.id);
delete from zf_contentpages WHERE authorid NOT IN (select id FROM zf_user);
delete from zf_reply WHERE (id >=2000000 AND id <= 3000000 ) AND tid NOT IN (select id FROM zf_contentpages);
