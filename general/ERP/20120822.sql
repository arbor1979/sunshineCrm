UPDATE `systemlang` SET `chinese`='��������' WHERE (`systemlangid`='3491') LIMIT 1;
UPDATE `systemlang` SET `chinese`='�½���������' WHERE (`systemlangid`='4331') LIMIT 1;
UPDATE `systemlang` SET `chinese`='�༭��������' WHERE (`systemlangid`='4332') LIMIT 1;
UPDATE `systemlang` SET `chinese`='�鿴��������' WHERE (`systemlangid`='4333') LIMIT 1;
UPDATE `systemlang` SET `chinese`='������������' WHERE (`systemlangid`='4334') LIMIT 1;
UPDATE `systemlang` SET `chinese`='���뾭������' WHERE (`systemlangid`='4335') LIMIT 1;
ALTER TABLE `buyplanmain_mingxi` ADD FOREIGN KEY (`mainrowid`) REFERENCES `buyplanmain` (`billid`) ON DELETE CASCADE ON UPDATE CASCADE;