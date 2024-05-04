<?php


class Model {
    protected $table = 'post'; 
    protected $primaryKey = 'id';
    protected $summerNotes = array(
        'content'
    );

    protected $allowedFields = array(
        'title',
        'content',
    );

    public function where(){

    }

    public function createdAt($data){
        $data['created_at'] = 'now()';
        return $data;
    }

    public function updatedAt($data){
        $data['updated_at'] = 'now()';
        return $data;
    }
    
    public function find(){
        $db = DB::getInstance();
        $sql = "select * from {$this->table}";
        return $db->query($sql);
    }

    public function findById($id){
        $db = DB::getInstance();
        $sql = "select * from {$this->table} where {$this->primaryKey} = $id";
        return $db->query($sql);
    }
    
    public function save(){

    }

    private function checkFields($data){
        foreach ($data as $key => $val){
            if(!in_array($key, $this->allowedFields)){
                unset($data[$key]);
            }
        }
        return $data;
    }

    private function checkSummerNote($post_data){
        foreach ($this->summerNotes as $key) {
            if(in_array($key, array_keys($post_data))){
                $post_data[$key] = SummerNote::save($post_data[$key]);
            } 
        }

        return $post_data; 
    }

    public function insert($data){
        $db = DB::getInstance();
        $data = $this->checkFields($data);
        $checked_data = $this->checkSummerNote($data);
        $prepared_data = $db->prepare($checked_data);

        $columns = implode(', ', array_keys($prepared_data));
        $values = implode(', ', array_values($prepared_data));

        $sql = "insert into {$this->table} ($columns) values ($values)";
        // return $sql; 
        return $db->query($sql);
    }

    public function update($id, $data){
        $db = DB::getInstance();
        $data = $this->checkFields($data);
        $checked_data = $this->checkSummerNote($data);
        $prepared_data = $db->prepare($checked_data); 

        $sets = array(); 

        foreach ($prepared_data as $k => $v){
            $sets[] = "$k = $v";
        }
        $sets = implode(', ', $sets);
        
        $sql = "update {$this->table} set $sets where {$this->primaryKey} = $id";
        // return $sql; 
        return $db->query($sql); 
    }

    public function delete($id){
        $db = DB::getInstance();
        $data = $this->findById($id);
        
        foreach ($this->summerNotes as $val){
            SummerNote::delete($data[0]->{$val});
        }

        $sql = "delete from {$this->table} where {$this->primaryKey} = $id";
        // return $sql; 
        return $db->query($sql);
    }
}