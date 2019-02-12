<?php
$parametersGPZ_CT=array( // parameters (tags) added to M100_PC's current transformer template
'!GPZ_SN!',
'!GPZ_TYPE!',
'!GPZ_PRIM_CURR!',
'!GPZ_UP!',
'!GPZ_SEC_CURR!',
'!GPZ_POWER!',
'!GPZ_CLASS!',
'!GPZ_DI_25S_120I!',
'!GPZ_DI_100S_120I!',
'!GPZ_DI_100S_20I!',
'!GPZ_DI_100S_5I!',
'!GPZ_DI_100S_1I!',
'!GPZ_DA_25S_120I!',
'!GPZ_DA_100S_120I!',
'!GPZ_DA_100S_20I!',
'!GPZ_DA_100S_5I!',
'!GPZ_DA_100S_1I!'
);

$parametersTemplateCT=array( // parameters in output template (CT), corresponding to input template (order must be the same)
'!SN$X!', // "$X" in each parameter is replaced with number from 0 to 9 in convert.php
'!TYPE$X!',
'!PRIM$X!',
'!UP$X!',
'!SEC$X!',
'!POW$X!',
'!CL$X!',
'!DI$X4!',
'!DI$X0!',
'!DI$X1!',
'!DI$X2!',
'!DI$X3!',
'!DA$X4!',
'!DA$X0!',
'!DA$X1!',
'!DA$X2!',
'!DA$X3!',
);

$parametersGPZ_VT=array( // parameters (tags) added to M100_PC's voltage transformer template
'!GPZ_SN!',
'!GPZ_TYPE!',
'!GPZ_PRIM_VOLT!',
'!GPZ_POWER!',
'!GPZ_SEC_VOLT!',
'!GPZ_CLASS!',
'!GPZ_DU_100S_80U!',
'!GPZ_DU_25S_80U!',
'!GPZ_DU_100S_100U!',
'!GPZ_DU_25S_100U!',
'!GPZ_DU_100S_120U!',
'!GPZ_DU_25S_120U!',
'!GPZ_DA_100S_80U!',
'!GPZ_DA_25S_80U!',
'!GPZ_DA_100S_100U!',
'!GPZ_DA_25S_100U!',
'!GPZ_DA_100S_120U!',
'!GPZ_DA_25S_120U!'
);

$parametersTemplateVT=array( // parameters in output template (CT), corresponding to input template (order must be the same)
'!SN$X!', // "$X" in each parameter is replaced with number from 0 to 9 in convert.php
'!TYPE$X!',
'!PRIM$X!',
'!POW$X!',
'!SEC$X!',
'!CL$X!',
'!DU$X2!',
'!DU$X5!',
'!DU$X1!',
'!DU$X4!',
'!DU$X0!',
'!DU$X3!',
'!DA$X2!',
'!DA$X5!',
'!DA$X1!',
'!DA$X4!',
'!DA$X0!',
'!DA$X3!'
);
?>
