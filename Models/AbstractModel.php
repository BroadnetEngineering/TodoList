<?php
interface AbstractModel {
    public function getList();

    public function delete($id);

    public function save($params);

    public function update($params);
}