UPDATE `systemlang` SET `chinese`='经济类型' WHERE (`systemlangid`='3491') LIMIT 1;
UPDATE `systemlang` SET `chinese`='新建经济类型' WHERE (`systemlangid`='4331') LIMIT 1;
UPDATE `systemlang` SET `chinese`='编辑经济类型' WHERE (`systemlangid`='4332') LIMIT 1;
UPDATE `systemlang` SET `chinese`='查看经济类型' WHERE (`systemlangid`='4333') LIMIT 1;
UPDATE `systemlang` SET `chinese`='导出经济类型' WHERE (`systemlangid`='4334') LIMIT 1;
UPDATE `systemlang` SET `chinese`='导入经济类型' WHERE (`systemlangid`='4335') LIMIT 1;
ALTER TABLE `buyplanmain_mingxi` ADD FOREIGN KEY (`mainrowid`) REFERENCES `buyplanmain` (`billid`) ON DELETE CASCADE ON UPDATE CASCADE;