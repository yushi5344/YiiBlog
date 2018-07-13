<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/13  20:24
	 * @param $tags
	 * @return array[]|false|string[]
	 */
    public static function str2Arr($tags){
    	return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/13  20:24
	 * @param $tags
	 * @return string
	 */
    public static function arr2Str($tags){
    	return implode(',',$tags);
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/13  20:24
	 * @param $tags
	 */
    public static function addTags($tags){
		if (empty($tags)) return;
	    foreach ($tags as $tag) {
		    $aTag=Tag::find()->where(['name'=>$tag])->one();
		    $aTagCount=Tag::find()->where(['name'=>$tag])->count();
		    if (!$aTagCount){
		    	$Tag=new Tag();
		    	$Tag->name=$tag;
		    	$Tag->frequency=1;
		    	$Tag->save();
		    }else{
		    	$aTag->frequency+=1;
		    	$aTag->save();
		    }
		}
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/13  20:25
	 * @param $tags
	 * @throws \yii\db\StaleObjectException
	 */
    public static function removeTags($tags){
    	if (empty($tags))  return;
	    foreach ($tags as $tag) {
		    $aTag=Tag::find()->where(['name'=>$tag])->one();
		    $aTagCount=Tag::find()->where(['name'=>$tag])->count();
		    if ($aTagCount){
		    	if ($aTag->frequency<=1){
		    		$aTag->delete();
			    }else{
		    		$aTag->frequency-=1;
		    		$aTag->save();
			    }
		    }
    	}
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/13  20:25
	 * @param $oldTags
	 * @param $newTags
	 * @throws \yii\db\StaleObjectException
	 */
    public static function updateFrequency($oldTags,$newTags){
    	if (!empty($oldTags)|| !empty($newTags)){
    		$oldTagsArray=self::str2Arr($oldTags);
    		$newTagsArray=self::str2Arr($newTags);
    		self::addTags(array_values(array_diff($newTagsArray,$oldTagsArray)));
    		self::removeTags(array_values(array_diff($oldTagsArray,$newTagsArray)));
	    }
    }
}
