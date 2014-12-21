<?php 
class Gps  extends fApplication{


	//绑定的数据文件名夹
	public  $_folder_path = 'cache/wearth/';

	//绑定的数据文件
	public  $_file_name  ='today';

	//绑定的数据文件后缀名
	public  $_file_ext_name  = 'html';

	public $_wearth_cache_exprise = 4; //多少小时缓存一次结果

	public $_city_code = array(
	'k_692e92669c0ca340eff4fdcef32896ee'=>"101010100",
	'k_05737a575bfe89eef1cc536d075268fd'=>"101010300",
	'k_33b2f3738b70b739af021609ffcc52b0'=>"101010400",
	'k_ad72f8550ba52a72b37fed6696ccf83d'=>"101010500",
	'k_7a0482e4054940bf9663a1b57ae493cb'=>"101010600",
	'k_a2121755c8096786c7bfafc3721b58f2'=>"101010700",
	'k_375299a8009712d973eab54950625f15'=>"101010800",
	'k_d635b97585529adb1b569770274f72fb'=>"101010900",
	'k_ba97fcde5483f0c20b6473c50e27b441'=>"101011000",
	'k_062cf01bf78db7579d4515460dfbf12a'=>"101011100",
	'k_812f3fca697fbd0cbca69008fac22ca3'=>"101011200",
	'k_7866a47d8bb261e9a377a0be2ff2c486'=>"101011300",
	'k_a54701703d0c7796f6e149c19aaad421'=>"101011400",
	'k_3ed757f39fa96da81e4acf4b502a54f7'=>"101011500",
	'k_202fc5960a6f9fff973db576a9d9c84e'=>"101011600",
	'k_f502c4a7e4437a128e97cf8cd5111c62'=>"101011700",
	'k_baee7ee7bbd32ef65bca26c7e40f6bd9'=>"101011800",
	'k_030d40a26a9e4b62bcac9731b1eed6bc'=>"101011900",
	'k_69a6c8d6d03f38f73314779124aa7d00'=>"101012000",
	'k_6742b1c82fd4eb915975bdc58de59da8'=>"101012100",
	'k_154e8761e5086bf5919f6797077358a9'=>"101012200",
	'k_c52568988fca093547d9f07856cd9522'=>"101010200",
	'k_b8b75a5f9109919ff3f67b336b62afe9'=>"101030100",
	'k_aa2efc96958868e83c27251740e65527'=>"101030300",
	'k_c3f49b29e72ed978206444dbb9a85cfc'=>"101030400",
	'k_b1d3b38e7edfb577027c9d572036b740'=>"101030500",
	'k_4f34789d027db0ba4c9ad592bffed93a'=>"101030600",
	'k_45ceb446a29ddeb8dac25550a36af247'=>"101031400",
	'k_009b6e282ad29f750ef027ccd641a28d'=>"101030800",
	'k_735f64751ea4d65f0cde1e7b201b1dda'=>"101030900",
	'k_b7b97bdae516b097c0a86323633a5605'=>"101031000",
	'k_2eaf19a31a7424fbc90f374bc46b063a'=>"101031100",
	'k_08eb6ebf61d7ec2ca44a4d7e83fd5aab'=>"101031200",
	'k_ee663b424a5b9f2d9d5032a47fef50b7'=>"101030200",
	'k_2e8ba777aeacf343b2590eb96caaad53'=>"101030700",
	'k_e94e8bd35fc8144f38fd1ebc1f81ab36'=>"101020100",
	'k_9ca75ac59a94374fab75106f0675bfb8'=>"101020300",
	'k_c50a9ffae3607340c518a21748595f19'=>"101020500",
	'k_f84cd9d7914cc67b2f53894e35b49a9c'=>"101020600",
	'k_673ccc0a0cac8665769e56e8e751f36d'=>"101021300",
	'k_63faa375f9188c608bdf9cbedff08323'=>"101020800",
	'k_f6abc275c3ebcfa291db2189300e763c'=>"101020900",
	'k_61f2b555ba2caaecd7fa995187580239'=>"101021000",
	'k_9eee33bfec3fd8b2f62733d6d6cb3607'=>"101021100",
	'k_d9a35de4166516132281724626feb2dc'=>"101021200",
	'k_edf3b5195cdbeb962a8bea56a8a7d96b'=>"101020200",
	'k_334facb5d20ccbf41e86e20a618cee3a'=>"101020700",
	'k_f34e15472b71fc5b6d23374ae893b7e1'=>"101090101",
	'k_0ad05831b638ec6879a528bc50abaf20'=>"101090301",
	'k_53f1aae521197424e0d369267ecc2e7c'=>"101090402",
	'k_0ae545752ac2977e267d911e70197b4e'=>"101090501",
	'k_6a6875e6f7b663252c69956c63088ce8'=>"101091101",
	'k_960a4ba267ea4f586c50e8d3166c0970'=>"101090701",
	'k_7dea8476f70bebf83dc177bb016b8170'=>"101090801",
	'k_997154c3fcfc03230a8d0f8d8762c7c3'=>"101090901",
	'k_4f52c3ae1e119c73f18424258e5ec754'=>"101091001",
	'k_381ac9c777ed773925db1b8fc9bde40a'=>"101090201",
	'k_c5469f1ff8f1c2a2821bfcda6b335452'=>"101090601",
	'k_c1a5e59d07daff85cfe0c44ecbd341d5'=>"101180101",
	'k_01a663cafe9ec921663f30da2790e8ad'=>"101180301",
	'k_8908a2ff6c91e895b1094cc530f09e2d'=>"101180401",
	'k_3c318b6ec7fdbf7d2c952f3a43a79e1b'=>"101180501",
	'k_1095769a798b55a145b23d290d2eaf85'=>"101180601",
	'k_e01baf35928ff35773776659eef9e2de'=>"101180701",
	'k_efed18d7995ff1c598cc98c5feccff6e'=>"101180801",
	'k_0549be0aaf1f796c6dcbbe37d89cd4f1'=>"101180901",
	'k_7e850eff72e6618227c77ec7991b362d'=>"101181001",
	'k_207a16e4ebfd210fed948b8278b00e3b'=>"101181101",
	'k_8645547da7268908fa26ebb39d69eb1e'=>"101181201",
	'k_dae475055decebcf7c7c60532324fc27'=>"101181301",
	'k_0fa51ce27b62d782eecdc65a42fcb4d4'=>"101181401",
	'k_fb50ae2c452d1a80058ac48e769b737d'=>"101181501",
	'k_54e144683f4a931397b265acff78089e'=>"101181601",
	'k_4b7f1040405694cf03fab0886d05c1b2'=>"101181701",
	'k_e3c6514d8d0f7d3094e68fa4c57cb1dd'=>"101181801",
	'k_0f0e1334efa2a11463ffa8d55842fe17'=>"101180201",
	'k_f5dc45d5d126a468387d14ae92a4a257'=>"101220101",
	'k_327cbd6e37ebcb52ad748f3cd7d1b371'=>"101220301",
	'k_c1c2a3aba3de4a405da3c00a45f70783'=>"101220401",
	'k_4a6840df0c3a0138dadaf805711036fe'=>"101220501",
	'k_1ab0fa2ad63b369b7905f1658f3e3d1b'=>"101220601",
	'k_b77ab73ba429763e88ec1ba1e6bacc7d'=>"101220701",
	'k_010b762dfd481f072aa5db74f326c975'=>"101220801",
	'k_940d1002f82c502e1d02205118dbbcab'=>"101220901",
	'k_1986d7d41d8a85a66e79421313ca50c9'=>"101221001",
	'k_cbb6d182efc9506accc8f6bb006cd8b2'=>"101221101",
	'k_3e59606ba2853b5c6630e48c62008ce0'=>"101221201",
	'k_f9a09eba4d5141d58ef0745afa0fab01'=>"101221301",
	'k_59a7c94fac38bcc463b07db1b1e45c5f'=>"101221401",
	'k_d0c3228f030917a886956d7ae474c8fa'=>"101221501",
	'k_3c5052d4b9e62c25e2b1d058756928db'=>"101221601",
	'k_56b2bd6d5f665b7219cada1b9089ff3b'=>"101221701",
	'k_7bfe909a828f96a525c91beeaf72ed96'=>"101220201",
	'k_69d6beffab0807555951e7f947224de3'=>"101210101",
	'k_88574fe0118ea8b9faae7e96c6394fbc'=>"101211101",
	'k_eacdb2c782e689526385db17a782be2c'=>"101210201",
	'k_572fd7fd9c9075b2d605b7f8c7b2735e'=>"101210301",
	'k_ac9755996ed1788df381d22e564c6dd0'=>"101210901",
	'k_5f085b2c16aafb6dac75a49901133fcc'=>"101210501",
	'k_392e7228a735450da30b7dc1da93d0fb'=>"101210601",
	'k_71f38f399ffad267d4f574228b491789'=>"101210701",
	'k_dbd49a91b51865d676f841f2e1c10716'=>"101210801",
	'k_231b2ab9d60b43ca24fe96863b59979a'=>"101211001",
	'k_ed5a4dc7333c6ac8b5ab91a6a8a917ac'=>"101210401",
	'k_78b0d703c7cf1ebadbf8eb5798b03e96'=>"101040100",
	'k_61edbd94d927c437be9838bbe0c99c8d'=>"101040300",
	'k_1e823da76ee7a9b95004737ba4cb5ff2'=>"101040400",
	'k_771592e6c69418b83be28366f75ae099'=>"101040500",
	'k_096363dcece428802cdbc7c93c00f3dd'=>"101040600",
	'k_4bc4f1f8669a821298fba6d2834a7809'=>"101040700",
	'k_4013ec61e545418a9b1d9a075924e9a8'=>"101040800",
	'k_dc552cf39858310500fe21f3e4b9cf5b'=>"101040900",
	'k_91b12cb9a1664fa3c317f157c2849aa5'=>"101041000",
	'k_2f13ea8537ac7377bfdc890bd6d38ea4'=>"101041100",
	'k_e48822da714b23cb2562526964dafee4'=>"101041200",
	'k_e375dd4c176fb1fc4ddc22b2e32d4510'=>"101041300",
	'k_61a0122db9e1bf852d0a344b73aa3970'=>"101041400",
	'k_89890cf5bcc051d0b0677aaea1da1ec5'=>"101041500",
	'k_5d57de5c2a4a89319cdc78bc0296ac4e'=>"101041600",
	'k_0f29bbb065540234375d8dd03844316a'=>"101041700",
	'k_a61347dbd136934ccc0166544abd65e9'=>"101041800",
	'k_75202920c7e15e7b08399aa5ca968833'=>"101041900",
	'k_686496a143f2d80403fea7fb8b63463d'=>"101042000",
	'k_e9d83412ced2d61acedfe2a59c75355d'=>"101042100",
	'k_edfc3c5ceaea0920d6f2ed4a36accf6b'=>"101042200",
	'k_e060e30b9f68b5b7f9663d80752c0e9a'=>"101042300",
	'k_b1e2a101cdaab323cf600717be718354'=>"101042400",
	'k_932b07f6378f0950aa249f06008829a1'=>"101042500",
	'k_7b15dd82e5e31ebe3442aad212399937'=>"101042600",
	'k_647088ecd166b608a8343d711c10bde4'=>"101042700",
	'k_a4ab07ef54091f7b1bd69c4871a15d06'=>"101042800",
	'k_e575362b808393deab7e563b6d501cda'=>"101042900",
	'k_105fbfd8fc4931cdd796dd399f2b4d40'=>"101043000",
	'k_e82128a70b8af4239470147d1eb94383'=>"101043100",
	'k_274e5b24e4ec8b7ca253002ae215abda'=>"101043200",
	'k_48d77677548c48d2c0811c09a9a8a0f1'=>"101043300",
	'k_b1f6ce5850035f21cb89c31a7dda2fe6'=>"101043400",
	'k_95ad508013ddc3750f0bdf125012ad54'=>"101043600",
	'k_a0ad587c7fe4b666713655c2a11b775c'=>"101043700",
	'k_951b37e7b3c075ea2b27289fcd465bcb'=>"101040200",
	'k_1096da16c3424fb419d5c894ec31b098'=>"101230101",
	'k_3716e00840911225f38620dc8eeca023'=>"101230501",
	'k_e4b0f718502992d3d9e2da43a6c7caf4'=>"101230601",
	'k_1c24fe89814115db6c6c131f5ad93d1b'=>"101230701",
	'k_9eddf74e590a20de4d853aa415f29a6d'=>"101230509",
	'k_2bd90d301df4eb233f7c7c5fdca5de1a'=>"101230901",
	'k_597f60c6ed8b98755295705522e02a1a'=>"101230201",
	'k_b52ae08c41ed3ea8b6adddfb2f4302a9'=>"101230301",
	'k_5d2193be51949b4839636e0a91e68195'=>"101230401",
	'k_92c6185c9cae661ada128d31fc123b5e'=>"101230801",
	'k_2e90ebdfa54b786339c44d38f92cce10'=>"101160101",
	'k_63ad839ef3f8129335be2f4a146f9e93'=>"101160301",
	'k_eab509f0aa5c65b3fa8d17adad88109d'=>"101160401",
	'k_24dcb6b0fee84d45a1acef4525f13c92'=>"101160501",
	'k_7c0d4c80b495a4916cee076f51d6b312'=>"101160601",
	'k_7ebdcf45219be24dd9703c8391cd54e7'=>"101161401",
	'k_ca6d761819663062fde2788c3e4928d6'=>"101160801",
	'k_3241a21e2b48f57718fda75623e39b79'=>"101160901",
	'k_701dd6a176c5abd9c3ee2d38250ed967'=>"101161001",
	'k_d324ab1055734f16ceb10c1a7c8da978'=>"101161101",
	'k_e673449dfdd0ccc339cae9a29aab3539'=>"101161201",
	'k_191c1de0b524068813eba62297bc5611'=>"101161301",
	'k_9bdba8e657115ff24e825423adaf4271'=>"101160201",
	'k_2a88d449f1f6efd3ca471b4e2122ebe3'=>"101160701",
	'k_7e040aa9cb2ec494b0a4d52c147e682c'=>"101280101",
	'k_969e2ac9293c9bd3159b159f7827675f'=>"101280301",
	'k_82a1ca05b578aa895c6d4f25b0beb838'=>"101280401",
	'k_81937d70030e2b2f2486ac114be03160'=>"101280501",
	'k_7a399889b9a4aed64afd0cf95941b975'=>"101280601",
	'k_c71c75e7b0520736ddda8a2083ec8e6e'=>"101280701",
	'k_852861b8913ea3aa2db9a3a911e8e360'=>"101280800",
	'k_de0b9d70ca568a486cd14d3b044cd0b6'=>"101280901",
	'k_63a8d524b17d22370f59ab95e9ea1e6b'=>"101281001",
	'k_1474a900cc4f73077871483735246587'=>"101281101",
	'k_df8661e86ef7a7cd29bf227a7ee322f0'=>"101281201",
	'k_8d24200c20f770844783d18fa44deee3'=>"101281301",
	'k_edb648c54749e1efed7006f6f4e8af6d'=>"101281401",
	'k_27c3181d2c4bd8838a7ab4269e524681'=>"101281501",
	'k_027110256c5981537e20cb8a3c192fa2'=>"101281601",
	'k_0c23a7f100f9a5def5fc83dcd3bc433a'=>"101281701",
	'k_171a19ced9df1940cbabfb8722506a77'=>"101281801",
	'k_f3ee70860b1ccffa1546110f44de707b'=>"101281901",
	'k_ff6d8fe81551d8fb1282592b6162d69e'=>"101282001",
	'k_19dd213af2f15099c458ab6ed17927ac'=>"101282101",
	'k_4d1c8936bd58215118a6d1c23dca0ed0'=>"101280201",
	'k_05acf573f5c097403fbdc1df51afde26'=>"101300101",
	'k_3b05fc7ed470c2e9064d999649fea4d6'=>"101300301",
	'k_44f931c142090038ca198684894eb197'=>"101300401",
	'k_1a57149358c03f7aba51b3eeb6f87cac'=>"101300501",
	'k_001636faeaacf9aed6f85ee2f8dbae8d'=>"101300601",
	'k_74c0b242b12052df67a2f0612ceff2bf'=>"101301401",
	'k_a01aec25d4bd243490e9a2cb4376e44c'=>"101300801",
	'k_f9e7f28458f0f713c236e782986be935'=>"101300901",
	'k_6d9dcfd9384007b25e2b32a7aec3a354'=>"101301001",
	'k_124766f6713f9544c4c8ab807e09fffa'=>"101301101",
	'k_7468219419b7784cf38e5ba5c4d343c1'=>"101301201",
	'k_5ebbabf2d495b42752f18a19954beef0'=>"101301301",
	'k_54cb45230417440312a0f55ca1bcd8ad'=>"101300201",
	'k_02df13aa3022efe53f1eeab159991d00'=>"101300701",
	'k_ef7f9f824c3336aa37b11f239d74bc91'=>"101260101",
	'k_23f44742bb54cd76a659234e2c17c0ac'=>"101260301",
	'k_b986f23ed03608a5b555033bfad8efa1'=>"101260401",
	'k_db1fc2d034ed004c55e4a71bcfbf2af4'=>"101260906",
	'k_328ef50d053f03ffed57895ace5affbd'=>"101260601",
	'k_a3bd31a087f028737728a6fa8ad1c5bc'=>"101260701",
	'k_b8982c4df16530c276a07f0896aef358'=>"101260801",
	'k_93e3e2ceec829853cc188e9d4f51f99c'=>"101260201",
	'k_6ebe4fdd627bca112f3bb14593e5fee6'=>"101260501",
	'k_41fe9aad429032c200c53c30e8fee0e5'=>"101290101",
	'k_124435916d7e104ac4d2521e49ba8ab4'=>"101290301",
	'k_b35fa32de521806ef5567b6f6ad1f749'=>"101290601",
	'k_62b58ac698293382c2ebf3bac347e79e'=>"101290701",
	'k_42ed1494a5995343dd7f9c087636a116'=>"101290801",
	'k_c4035013b2a3866012272148ceffa432'=>"101290901",
	'k_b38a173a3d4a4c9abbbebe26564241c5'=>"101291001",
	'k_c113c5a33aa98644d19132aa1a364144'=>"101291101",
	'k_7e7d9bd7943995815f5a3de60f50f3f4'=>"101291201",
	'k_9717837757352b9e442832970d015079'=>"101291301",
	'k_7bb4299d34eda19b62272e6ae6c761a1'=>"101291401",
	'k_7bf59e3a312827a780a07b8fdf6a130e'=>"101291501",
	'k_fb5188e30cc468640637b2fd72885ba6'=>"101291601",
	'k_d93467c50a4ceefe4f17bfba80c8da83'=>"101290201",
	'k_8be217918f083e921a104eb5a8b33787'=>"101290401",
	'k_0fcb8bf277a262a00116eb584709fa8a'=>"101290501",
	'k_e8fc833958f84db2bd5a4e0cafa0d9e3'=>"101080101",
	'k_c7a32b54f42edd95ad1df6390c5d5571'=>"101080301",
	'k_9c2efbd014df0a41d330ace266839e94'=>"101080401",
	'k_81f4606c32f617460e10adb62385de17'=>"101080501",
	'k_cdd2bf6590994a762792d67fc2649dd0'=>"101081201",
	'k_666d64d6c1015fe61640e500733ab761'=>"101080701",
	'k_25b9e950448781cfcfdcbd9cdfb1b580'=>"101080801",
	'k_d87a53a21350108a19e538227c82a3b7'=>"101080901",
	'k_2565ea517ce30e3a0fab999349d70b7c'=>"101081000",
	'k_27f52c22977be1e63cf093e06b24f0ba'=>"101081101",
	'k_e132301844dcd546acd168e4997223fe'=>"101080201",
	'k_a896ed6b525f37632c97858bfdf86550'=>"101080601",
	'k_1db4a42c28a20e824f8bf25a442229a1'=>"101240101",
	'k_7e5db6d49ccbcc5db919431b86c32efb'=>"101240301",
	'k_a78b87eb57eb9cb9e31be4ccd5a8fb59'=>"101240401",
	'k_10df11847522e78561b6ad104976f53d'=>"101240501",
	'k_228bd2a03e15c9ac7d8d7791981d41db'=>"101241101",
	'k_8ebd5d853db2ee913b3c1bf685741b52'=>"101240701",
	'k_f5e157304fab76074f7aae09455efabf'=>"101240801",
	'k_dafbf7fbd688f4b2cc968ed2606ba9b7'=>"101240901",
	'k_e2c26016d9df61bb4fa02fec894c5cbf'=>"101241001",
	'k_d3c9a9eb8ae67926e9e62f4d99410c3e'=>"101240201",
	'k_09d6997489ce1b236e548cd8453de351'=>"101240601",
	'k_ad9efa2f14d42f7d14ef876725909e27'=>"101200101",
	'k_91978b411d0f905beff66cb6046d3205'=>"101200501",
	'k_731028f1e14d19db8adf68ae407af242'=>"101200801",
	'k_09aebff41f22d3cf999f0d80f4cdcd79'=>"101200901",
	'k_570507d809b8970cc15a31a9d4806843'=>"101201001",
	'k_6de818644adb76763c84d6eba00d9d89'=>"101201101",
	'k_f3b1c52bcd04940933ab48b857104482'=>"101201201",
	'k_7d81ef23d922fb89442b055b068f7ee4'=>"101201301",
	'k_63f84ed8b2d6c102640c682cdce67f92'=>"101201401",
	'k_921f0f3fc99c991236d1b38253e1f411'=>"101201501",
	'k_c964a9c694cd8ddc83ef45c4084c1077'=>"101201601",
	'k_5085f353eda45fabbea332941562d936'=>"101201701",
	'k_d8c073626d60ee0918022f316dd2864a'=>"101200201",
	'k_e04d399d0ed3d53565b4a3e5bf701fd1'=>"101200301",
	'k_adad1295e8291bab381cf322bc2d0318'=>"101200401",
	'k_c97245daea5e8c6a2ca470bb117c12fe'=>"101200601",
	'k_9c6597e3f76297be1ecdc20033865bb6'=>"101200701",
	'k_14bf5c897776f11648134a65c8365b77'=>"101270101",
	'k_5d7baeaaa931f43b21693183193f7b7c'=>"101270301",
	'k_a8f4e63b3db304b5b5ced74f69b29a3a'=>"101270401",
	'k_1d12d4e9ada24f2d9e6d52d6b477144a'=>"101270501",
	'k_b714eedcb8d6610a2174afa66152a5ce'=>"101270601",
	'k_0ef46b479c929c086c9a6206f656a46b'=>"101270701",
	'k_e21a0fd9100e69f1702e11a9201b75b2'=>"101270801",
	'k_f6f971c484f45e3fd1a567a7652a93d9'=>"101270901",
	'k_f73035874de82bdbe7e8098b06e8828c'=>"101271001",
	'k_f18e49b29ad9558d3d48940921b123c8'=>"101271101",
	'k_0af2f501426764662551b22ae9db0a8d'=>"101271201",
	'k_40d82e436415b7282619de9013fb528a'=>"101271301",
	'k_f2efa8f0f8646ab15269981d5a3fee17'=>"101271401",
	'k_ab692c9cf01a5ef9fb6ee1cb6ed07a34'=>"101271501",
	'k_ebf676195f9fe6950bad02fae8944eb5'=>"101271601",
	'k_9c1671b23b75d479d160a712ab49152f'=>"101271701",
	'k_246f0af925aa6e7e4efddf39441258b5'=>"101271801",
	'k_2b8bdf17b95eb54cbc14aaeb5d792579'=>"101271901",
	'k_b8b3061b7cc860b1b54342f143709ffd'=>"101272001",
	'k_5455ef2fc6a3c810bbf4df14e08e3f96'=>"101272101",
	'k_929a47228d48eb7459d960a1c25763c9'=>"101270201",
	'k_0a5a5caa147057200a85075b83d454a7'=>"101170101",
	'k_b2207118c5427f9539d611aadd0e32aa'=>"101170501",
	'k_f02ab255cea8460f161d4a2be8f57dba'=>"101170401",
	'k_0d9a7940fbf173910617b3d833ff106f'=>"101170201",
	'k_7e610bf301c1bd67daf3bb28bd07e6ad'=>"101170301",
	'k_1fe5f0f6a300c0841adadef898a18c81'=>"101150101",
	'k_27ff1fc1a7e7c37f20a28c41c39f6da7'=>"101150301",
	'k_fea43faef65b12094dc7d98c8dd52659'=>"101150801",
	'k_991b8037aeff49ca9cf4d8387300b0c3'=>"101150501",
	'k_33cb649c2a82054cd613a5113974ee7d'=>"101150601",
	'k_63bdd27b7a0a9bc522b4bc7391d41d11'=>"101150701",
	'k_2d24a37eef5b01b7626ee99ea1e4585a'=>"101150201",
	'k_78f76e6a5e3b7c3031ac9ed649f9d655'=>"101150401",
	'k_8f55a5c898a5ace2ac06ff02ece7455a'=>"101120101",
	'k_0b7783a6cbd0497ce6355ef682dd1b20'=>"101120601",
	'k_8500feec62b6f83ccf373efabe851fdb'=>"101120901",
	'k_f64f08c2d7060e78eb81388ef9bab935'=>"101121001",
	'k_a6a6d5707de84576c70f5d5641ea757d'=>"101121101",
	'k_7fe1d144a4f99d7b0c7a55c2f64c5a94'=>"101121201",
	'k_22e8aa6f4bc2340404fd722569f3c9b6'=>"101121301",
	'k_94c5254514f598dafae4c91f124b4431'=>"101121401",
	'k_75b74a021b4996a00dfb81e29771aa97'=>"101121501",
	'k_8e6c758a5f3f9b7edf37fe8eb6898c35'=>"101121601",
	'k_d6ea46df68919484991d86e39e783f50'=>"101121701",
	'k_05ec55f037391b53f4c537c33e0a24bb'=>"101120201",
	'k_285c2d840adbecb36aabcf54cd0b1453'=>"101120301",
	'k_57ed0d8bb08312ec4030afa0f0588219'=>"101120401",
	'k_8a18d8a51f74141b804f141f20783e46'=>"101120501",
	'k_644e2a6e72ef2f8044516dedf29a9d0a'=>"101120701",
	'k_c06997d591d1125cf0120bfd7e2cf521'=>"101120801",
	'k_79b21044d044c5fdcf52db2d22d73fb7'=>"101110101",
	'k_5794d4230c3ba4c4caadbdad75b99b84'=>"101110300",
	'k_598e6c3ce248cb25669a760f2564cebe'=>"101110401",
	'k_bd59a636e163e914d94c4a17a9fbebd4'=>"101111001",
	'k_3ba3dcaa876545504bae5ae02491213b'=>"101110601",
	'k_0e093d5689a947cdab04321e83215fbf'=>"101110701",
	'k_d6bc7ed248c0636a73741220e0d8d373'=>"101110801",
	'k_ba0a2b8b055a2aa5be22c3c7da1ab30c'=>"101110901",
	'k_164024350678532ce02af496acbf3c0a'=>"101110200",
	'k_afbf09e978ef660811747917bfcfc47a'=>"101110501",
	'k_fd2ebae36d8b7f69357cd6adc8f2330a'=>"101100101",
	'k_51ed5067c29e91c7219222e9dea95a0e'=>"101100701",
	'k_651cd625b361a6ce8290dd521024a0ff'=>"101100801",
	'k_2beb0e21179b4196c75db616f3c65220'=>"101100901",
	'k_757b0715e12160e3d3b72e4ef4080062'=>"101101001",
	'k_d1f164c4b5160690ec3fa660b4488626'=>"101100501",
	'k_ff1b9826ad92284f3587c182a9933bde'=>"101100201",
	'k_dda795c22bd52ff1c6faf9310baebca6'=>"101100301",
	'k_1868162c3c75975acc4bdf0a4bf50bb0'=>"101100401",
	'k_4cde74c271065c8f1bb536f872ae9c30'=>"101100601",
	'k_a7c2cb53bc4b8824b06a12740915e17a'=>"101101100",
	'k_1574573601416cb6ed27320eb3246fdb'=>"101130101",
	'k_02e0ea1785ea41ce18c3dfbdd1b38f52'=>"101130301",
	'k_298b067982a36b9163e0ba6c06c23a7b'=>"101130401",
	'k_8a5873ab9f79764d03f756cf92969b7e'=>"101130501",
	'k_fd8611c1dc2c97823eaffba17eaa38f0'=>"101130601",
	'k_250cad860a4ee2f1f42d3961fb968bbf'=>"101130701",
	'k_ddf2a8de7da8d8b551e6daf9ffc3a9fc'=>"101130801",
	'k_80fd99d6d93d9af4d5bc54745c863a40'=>"101130901",
	'k_ad5781137225d8683ab2c78a59b1cd96'=>"101131001",
	'k_11a63e1f07c76dab454c74199c72c078'=>"101131101",
	'k_65ea7e03583cb3c8ab7596debf85cee2'=>"101131201",
	'k_6266c41aebd1e7432ee77fe69be94560'=>"101131301",
	'k_e7b46a54afa2aa9228672625187b3487'=>"101131401",
	'k_2509be5c14647e8d4dc35d22d7f43b7e'=>"101131501",
	'k_7adb19dff3e5bbc693ad321e56427509'=>"101131601",
	'k_456ae6d2ab6e1a234ecee4fad9157cd6'=>"101130201",
	'k_c289438c5f921d1675ea8b1501902d85'=>"101140101",
	'k_8037a819abb80c9b880566ea49cad153'=>"101140301",
	'k_5ac0b6e56fba67ca6c16f36e694563fc'=>"101140701",
	'k_4676396f7ceae80307efe83f1c5f45ca'=>"101140501",
	'k_f2529980616dec377d724b2ff4eba20a'=>"101140601",
	'k_ba2a36e22f02e7246aa8758430404b1b'=>"101140201",
	'k_3824bf51a677755fcf616e0e466a5937'=>"101140401",
	'k_46157d480e11036baf5398a1ec420348'=>"101340101",
	'k_85758b78e13ab7d32e14c3ece11d9651'=>"101340201",
	'k_7704905f1c8f02c72aac8d6f9a9b652d'=>"101340401",
	'k_ca8c986da4349b6fbbe272e3d1536e95'=>"101310101",
	'k_fcf3af2237af9eae5bb1c3f55951b731'=>"101310201",
	'k_b7b80022c8105bd688c8e087eb0eb672'=>"101310202",
	'k_d49b7a742b22d7346cccc1e65fe1d1d4'=>"101310203",
	'k_cbb581fdc8cd8de04b55a860a5f4876e'=>"101310204",
	'k_19fb884a71e208e52b2d94fe8349ae12'=>"101310205",
	'k_791c1fe0504dbddf11f6823037b86960'=>"101310206",
	'k_0af744d0e4ff0b01b419ccd9b9d202ca'=>"101310207",
	'k_8104f3de250e90b62ecf3722cc6b86d4'=>"101310208",
	'k_38c919e11bd4d0a03fc14773d661a00b'=>"101310209",
	'k_365b510ba89d2e08ce65b2baaefef3b0'=>"101310210",
	'k_7fa780467470c2b6ea02bcea2af6685c'=>"101310211",
	'k_e4838957192204f430980b6254f654f8'=>"101310212",
	'k_2c5b9a81057074d64bb03b8802323344'=>"101310214",
	'k_cd21b41cb963578af34ccef3ebd2990a'=>"101310215",
	'k_ab5cb705d1289ba1aca12797dde8e50f'=>"101310216",
	'k_9087ff709780c86e76bcd15d4631a5bd'=>"101310217",
	'k_7c8be9ac2de3b01479bac949a2ecc4e4'=>"101310220",
	'k_1c5471eb5576e7baa7fab308aaf79b20'=>"101310221",
	'k_5743e46052f7f3a3c8b213330cdb0195'=>"101310222",
	'k_e2684710f826b131d5a9dc3722ff67ba'=>"101310102",
	'k_6b357589b12f6141fc48c4b0375ef2f9'=>"101250101",
	'k_2ec31e07277ccc181f82761cf483753d'=>"101250301",
	'k_ec83055a4aaa2af6a066405b84c616a2'=>"101250401",
	'k_95fd99943946f611d9d81661cd36f4ba'=>"101250501",
	'k_d888c36f9c659a8d015e4d38b56acec1'=>"101250601",
	'k_d69989a29a01bf0b2c8b9553265fcbcb'=>"101250700",
	'k_9859819c6bc80bb1ca4bff702dd3f9ca'=>"101250801",
	'k_08c21488c34174922fa90eab2ee771d8'=>"101250901",
	'k_bb5c195fc1870f1ec5f90aa0a2b34681'=>"101251001",
	'k_1260698db1f035833b44c07e88c26b58'=>"101251101",
	'k_fa78c7031651e2b9149b752d904319f4'=>"101251201",
	'k_3672c337a61e98358b02c861e9870458'=>"101251301",
	'k_75ea0bee5a6b6030344a350d09c2de51'=>"101251401",
	'k_bf1e05de6e35524d048f3ae11ab4b754'=>"101251501",
	'k_d5aa6287c3483e7ca2a31e524c6db528'=>"101250201",
	'k_ad827c5906e6097904964bf48d70a06d'=>"101190101",
	'k_35d2f366077fcb670ce0f5d78c21b030'=>"101190301",
	'k_995882b996619ea85a44333150e7014e'=>"101190401",
	'k_17f86f3907de628c185d8c32839028b4'=>"101190501",
	'k_62d3121c3670984dfbf9b1c31a08be8c'=>"101190601",
	'k_4cff4ea00b4396d75e9be388a0dc60bd'=>"101191301",
	'k_3fe7f3810619f6f886fb12f637ea8028'=>"101190801",
	'k_6dc16ea4e5d9ccf57be5020ea8da97e6'=>"101190901",
	'k_6cd1ddd713d230bff64549058ffddeb6'=>"101191001",
	'k_880490aef6afebb93f602e5469cb5a16'=>"101191101",
	'k_1c1a12cefc515b553792fb9c94e67d76'=>"101191201",
	'k_cc6b473b7ea2f23546d0361573b98b30'=>"101190201",
	'k_640eb5069b38900c0864493cfbda4a6e'=>"101190701",
	'k_f563daa4b1629c7c53fd802f2976fdba'=>"101050101",
	'k_6909289dbaaed927d2197ba03684fa6f'=>"101050301",
	'k_9ca795adf5808603f1bbd6644ecd92d0'=>"101050401",
	'k_678257ed8376888679eb0af1513cea16'=>"101050501",
	'k_6d9dc3a09ebb8e4e115d7e922cee0ab5'=>"101050601",
	'k_9cae86cba79eadc4cb6717e560e7e27e'=>"101051301",
	'k_a08c5043c3edf393ca029d1d7f4a00a4'=>"101050801",
	'k_a8d5049637e5cfc528ac0a36129331a1'=>"101050901",
	'k_a657ba979f3fba9c9177a030731fc7c2'=>"101051002",
	'k_a8a43b72e8343d9090ac1607914b128b'=>"101051101",
	'k_7ac9f0ec6fbc12d19a72246fac3e6d14'=>"101051201",
	'k_5268833e01ca5f52cb0cc79f1a64b62f'=>"101050201",
	'k_f5cdb5c0757a90cc77a697170b554521'=>"101050701",
	'k_2018c3e9567630879ae89d0d71d0d9f2'=>"101060101",
	'k_7f865ae78d56144db7ab5a0c83c0fa2f'=>"101060301",
	'k_d8d7535f56836f56d63ccde623c9e510'=>"101060401",
	'k_3c98c90f23425fd8d3dcebe04b8d2fdc'=>"101060901",
	'k_90bd3efdf0297392e76287d82bc33174'=>"101060601",
	'k_100d12f2f32b7fcb4d8a61a5aecb413c'=>"101060701",
	'k_8cc386a93908ad3faa82c5558ea8ccac'=>"101060801",
	'k_4013c127fd249166369c7430c2824bf8'=>"101060201",
	'k_64b58d400f6179a262556499b9ba92da'=>"101060501",
	'k_be57fee22b93ac3145df2e17e1e5ee1b'=>"101070101",
	'k_927b4c40f23608433397c665c5216b7d'=>"101070301",
	'k_3e894a6daa89af6e1f87df6410a849b7'=>"101070401",
	'k_8e2ec5889f413197d8b3ef9e221898c9'=>"101070501",
	'k_dc19b9db331ad97dc2587ccf9ecb8317'=>"101070601",
	'k_e4a8b4a43f657ac2d2c5478bd49f2e8d'=>"101071401",
	'k_9744c5abb8836c3f06e5b2d95c3ab625'=>"101070801",
	'k_78d09eaf8edde56dd0b6c6de3cefb237'=>"101070901",
	'k_34f72f0f970ad0b9b051c4f825621f46'=>"101071001",
	'k_58132494911a447959dfec4d17cbe2c1'=>"101071101",
	'k_05737a575bfe89eef1cc536d075268fd'=>"101071201",
	'k_e9f16b74ab391d904b9acd5a7f24bfe8'=>"101071301",
	'k_386831d62e2bf88e310031b85122cf72'=>"101070201",
	'k_7ebfb5629e6be5b4c60c3f454798478c'=>"101070701"
	);


	function generate_cache_file_name($code){
		$file_name =intval(date('H',time()) / $this->_wearth_cache_exprise ) ;
		$file_name = md5($code.date('Ymd',time()).$file_name);
		return $file_name;
	}
	function city($latlng,$city){


		$ctx = stream_context_create(array(
		'http' => array(
		'timeout' => 10 //设置一个超时时间，单位为秒
		)
		)
		);
		$result = array();
		if(!$city){
			//		$url ='http://maps.google.com/maps/api/geocode/json?latlng=116.5010991,39.9219337&language=zh-CN&sensor=true';
			//		$url = 'http://maps.google.com/maps/api/geocode/json?latlng=30.5985697,104.0964577&language=zh-CN&sensor=true';
			$url = 'http://api.map.baidu.com/geocoder?output=json&location=30.5985697,104.0964577&key=1b78a4946a1e26c7cd92b1ea09e3ebeb';
			$url = 'http://api.map.baidu.com/geocoder?output=json&location='.$latlng.'&key=1b78a4946a1e26c7cd92b1ea09e3ebeb';
			//		$url = "http://api.map.baidu.com/geocoder?output=json&location=$lat,$lng&key=1b78a4946a1e26c7cd92b1ea09e3ebeb";
			//		$url = "http://recode.ditu.aliyun.com/dist_query?l=39.938133,116.395739";
			$cnt=0;
			while($cnt < 3 && ($josn=@file_get_contents($url,0,$ctx))===FALSE) $cnt++;
			$josn = json_decode($josn);

			if($josn->status=='OK'){
				$city = $josn->result->addressComponent->city;
			}

			//			$city = ( $city ) ?$city:'北京市';
			$city = ( $city ) ;
			$city = substr($city,0,strlen($city)-3);
		}
		$wearth_api_key = 'k_'.md5($city);
		if( !array_key_exists($wearth_api_key, $this->_city_code ) ){
			return false;
		}
		$file_name =$this->generate_cache_file_name($city);
		if( !$this->get($file_name) ){
			
			$url = 'http://m.weather.com.cn/data/'.$this->_city_code['k_'.md5($city)].'.html';
			$cnt=0;
			while($cnt < 3 && ($info=@file_get_contents($url,0,$ctx))===FALSE) $cnt++;
			if($info){
				$info = json_decode($info);
				if(  is_object($info) && $info->weatherinfo) {
					$result['city']= $info->weatherinfo->city;
					$result['temp']= $info->weatherinfo->temp1;
					$this->set(serialize($result),$file_name);
				}
			}
			return $result;
		}else{
			return unserialize($this->get($file_name));
		}

	}




}
?>