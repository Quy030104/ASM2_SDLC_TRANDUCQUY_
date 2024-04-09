<?php
require "database/database.php";

function updateDepartmentById($name,$slug,$leader,$status,$begindate,$logo,$id){
    $checkUpdate = false;
    $db = connectionDb();
    $sql = "UPDATE `dipartments` SET `name` = :nameDepartment, `slug` = :slug, `leader` = :leader, `date_beginning` = :beginDate, `status` = :statusDepartment, `logo` = :logo, `updated_at` = :updated_at WHERE `id` = :id AND `deleted_at` IS NULL";
    $updateTime = date('Y-m-d H:i:s');
    $stmt = $db->prepare(($sql));
    if($stmt){
        $stmt->bindParam(':nameDepartment',$name,PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':leader', $leader, PDO::PARAM_STR);
        $stmt->bindParam(':beginDate', $begindate, PDO::PARAM_STR);
        $stmt->bindParam(':statusDepartment', $status, PDO::PARAM_STR);
        $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updateTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $checkUpdate = true;
        }
    }
    disconnectDb($db);
    return $checkUpdate;
}
function getDetailDepartmentById($id = 0){
    $sql = "SELECT * FROM `dipartments` WHERE `id` = :id AND `deleted_at` IS NULL"; //lay thong tin chi tiets cua 1 khoa
    $db = connectionDb();
    $data= [];
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount()>0){
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectDb($db);
    return $data;
}

function deleteDepartmentById($id=0){
    $sql = "UPDATE `dipartments`SET`deleted_at` = :deleted_at WHERE `id` = :id";
    $db = connectionDb();
    $checkDelete = false;
    $deleteTime = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':deleted_at', $deleteTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkDelete=true;

        }
    }
    disconnectDb($db);
    return $checkDelete;
}

function getAllDataDepartment($keyword = null){
    $db = connectionDb();
    $key= "%{$keyword}%";
    $sql = "SELECT * FROM `dipartments` WHERE (`name` LIKE :nameDepartment OR `leader` LIKE :leader) AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $data=[];
    if($stmt) {
        $stmt->bindParam(':nameDepartment', $key,PDO::PARAM_STR);
        $stmt->bindParam(':leader', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount()>0){
                $data = $stmt->fetchAll((PDO::FETCH_ASSOC));
            }

        }
    }
    disconnectDb($db);
    return $data;
}
function getAllDataDepartmentByPage($keyword = null, $start = 0 ,$limit= 3 )
    {
        $key = "%{$keyword}%";
        $sql = "SELECT * FROM `dipartments` WHERE (`name` LIKE :nameDepartment OR `leader` LIKE :leader) AND `deleted_at` IS NULL LIMIT :startData, :limitData";
        $db = connectionDb();
        $stmt = $db->prepare($sql);
        $data = [];
        if ($stmt) {
            $stmt->bindParam(':nameDepartment', $key,PDO::PARAM_STR);
            $stmt->bindParam(':leader', $key, PDO::PARAM_STR);
            $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limitData', $limit,PDO::PARAM_INT);
            if ($stmt->execute()) {
                if ($stmt->rowCount()  > 0) {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }
        disconnectDb();
        return $data;
    }

function insertDepartment($name, $slug, $leader, $status, $logo, $begindate){
    //viet cau lenh insert vao bang department
        $sqlInsert = "INSERT INTO `dipartments`(`name`, `slug`, `leader`, `date_beginning`, `status`, `logo`,`created_at`) VALUES (:nameDepartment, :slug, :leader, :beginDate, :statusDepartment, :logo, :createdAt )";
        $checkInsert = false;
        $db = connectionDb();
        $stmt =$db->prepare($sqlInsert);
        $currentDate=date('Y-m-d H:i:s');
        if($stmt){
            $stmt->bindParam(':nameDepartment', $name, PDO::PARAM_STR);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindParam(':leader', $leader, PDO::PARAM_STR);
            $stmt->bindParam(':beginDate', $begindate, PDO::PARAM_STR);
            $stmt->bindParam(':statusDepartment', $status, PDO::PARAM_STR);
            $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
            $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
            if($stmt->execute()){
                $checkInsert=true;
            }
        }
        disconnectDb($db);
        //tra ve true insert thanh cong va nguoc lai
        return $checkInsert;
}