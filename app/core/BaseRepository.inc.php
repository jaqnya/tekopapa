<?php
abstract class BaseRepository {

    protected static $table;
    protected static $sql_exception;

    public static function get_sql_exception() {
        return static::$sql_exception;
    }

    public static function get_reccount($connection, $company_id) {
        $reccount = null;

        if (isset($connection)) {
            try {
                $sql = 'SELECT fn_' . static::$table . '_reccount(:company_id) reccount';

                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch();

                $reccount = $result['reccount'];
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $reccount;
    }

    public static function id_exists($connection, $company_id, $id) {
        $id_exists = true;

        if (isset($connection)) {
            try {
                $sql = 'SELECT fn_' . static::$table . '_id_exists(:company_id, :id) id_exists';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                $result = $stmt->fetch();

                if (!$result['id_exists']) {
                    $id_exists = false;
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $id_exists;
    }

    public static function __callStatic($method, $arguments) {
        if ($method == 'name_exists') {
            if (count($arguments) == 3) {
                $connection = $arguments[0];
                $company_id = $arguments[1];
                $name = $arguments[2];

                $name_exists = true;

                if (isset($connection)) {
                    try {
                        $sql = 'SELECT fn_' . static::$table . '_name_exists(:company_id, :name) name_exists';

                        $stmt = $connection->prepare($sql);

                        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

                        $stmt->execute();

                        $result = $stmt->fetch();

                        if (!$result['name_exists']) {
                            $name_exists = false;
                        }
                    } catch (PDOException $ex) {
                        print 'ERROR: ' . $ex->getMessage() . '<br>';
                    }
                }

                return $name_exists;
            }
        }   //  { method: name_exists() }

        if ($method == 'get_by_name') {
            if (count($arguments) == 3) {
                $connection = $arguments[0];
                $company_id = $arguments[1];
                $name = $arguments[2];

                $results = array();

                if (isset($connection)) {
                    try {
                        $sql = 'CALL sp_' . static::$table . '_get_by_name(:company_id, :name)';

                        $stmt = $connection->prepare($sql);

                        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

                        $stmt->execute();

                        $results = $stmt->fetchAll();
                    } catch (PDOException $ex) {
                        print 'ERROR: ' . $ex->getMessage() . '<br>';
                    }
                }

                return $results;
            }
        }   //  { method: get_by_name() }
    }

    // public static function name_exists($connection, $company_id, $name) {
    //     $name_exists = true;

    //     if (isset($connection)) {
    //         try {
    //             $sql = 'SELECT fn_' . static::$table . '_name_exists(:company_id, :name) name_exists';

    //             $stmt = $connection->prepare($sql);

    //             $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
    //             $stmt->bindParam(':name', $name, PDO::PARAM_STR);

    //             $stmt->execute();

    //             $result = $stmt->fetch();

    //             if (!$result['name_exists']) {
    //                 $name_exists = false;
    //             }
    //         } catch (PDOException $ex) {
    //             print 'ERROR: ' . $ex->getMessage() . '<br>';
    //         }
    //     }

    //     return $name_exists;
    // }

    public static function is_active($connection, $company_id, $id) {
        $is_active = false;

        if (isset($connection)) {
            try {
                $sql = 'SELECT fn_' . static::$table . '_is_active(:company_id, :id) is_active';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                $result = $stmt->fetch();

                if ($result['is_active']) {
                    $is_active = true;
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $is_active;
    }

    public static function new_id($connection, $company_id) {
        $new_id = null;

        if (isset($connection)) {
            try {
                $sql = 'SELECT fn_' . static::$table . '_new_id(:company_id) new_id';

                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch();

                $new_id = $result['new_id'];
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $new_id;
    }

    public static function get_all($connection, $company_id) {
        $results = array();

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_all(:company_id)';

                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->execute();

                $results = $stmt->fetchAll();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $results;
    }

    public static function get_all_with_limit_and_offset($connection, $company_id, $limit, $offset) {
        $results = array();

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_all_with_limit_and_offset(:company_id, :limit, :offset)';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

                $stmt->execute();

                $results = $stmt->fetchAll();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $results;
    }

    public static function get_all_active($connection, $company_id) {
        $results = array();

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_all_active(:company_id)';

                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->execute();

                $results = $stmt->fetchAll();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $results;
    }

    public static function get_by_id($connection, $company_id, $id) {
        $result = null;

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_by_id(:company_id, :id)';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                $result = $stmt->fetch();
             } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $result;
    }

    // public static function get_by_name($connection, $company_id, $name) {
    //     $results = array();

    //     if (isset($connection)) {
    //         try {
    //             $sql = 'CALL sp_' . static::$table . '_get_by_name(:company_id, :name)';

    //             $stmt = $connection->prepare($sql);

    //             $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
    //             $stmt->bindParam(':name', $name, PDO::PARAM_STR);

    //             $stmt->execute();

    //             $results = $stmt->fetchAll();
    //         } catch (PDOException $ex) {
    //             print 'ERROR: ' . $ex->getMessage() . '<br>';
    //         }
    //     }

    //     return $results;
    // }

    public static function get_by_any($connection, $company_id, $any) {
        $results = array();

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_by_any(:company_id, :any)';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':any', $any, PDO::PARAM_STR);

                $stmt->execute();

                $results = $stmt->fetchAll();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $results;
    }

    public static function get_by_any_with_limit_and_offset($connection, $company_id, $any, $limit, $offset) {
        $results = array();

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_get_by_any_with_limit_and_offset(:company_id, :any, :limit, :offset)';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':any', $any, PDO::PARAM_STR);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

                $stmt->execute();

                $results = $stmt->fetchAll();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $results;
    }

    public static function get_by_any_reccount($connection, $company_id, $any) {
        $reccount = null;

        if (isset($connection)) {
            try {
                $sql = 'SELECT fn_' . static::$table . '_get_by_any_reccount(:company_id, :any) reccount';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':any', $any, PDO::PARAM_STR);

                $stmt->execute();

                $result = $stmt->fetch();

                $reccount = $result['reccount'];
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage() . '<br>';
            }
        }

        return $reccount;
    }

    public static function insert($connection, $user_id, $model) {
        $model_inserted = false;

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_insert(:user_id, :company_id, 0, :name, :active)';

                $company_id = $model->get_company_id();
                $name = $model->get_name();
                $active = $model->is_active();

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);

                $model_inserted = $stmt->execute();
            } catch (PDOException $ex) {
                if ($ex->getCode() == '45000') {
                    $pdo_exception = explode('│', $ex->getMessage());
                    static::$sql_exception = $pdo_exception[1];
                } else {
                    print 'ERROR: ' . $ex->getMessage() . '<br>';
                    print 'ERROR: ' . $ex->getCode() . gettype($ex->getCode()). '<br>';
                }
            }
        }

        return $model_inserted;
    }

    public static function update($connection, $user_id, $model) {
        $model_updated = false;

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_update(:user_id, :company_id, :id, :name, :active)';

                $company_id = $model->get_company_id();
                $id = $model->get_id();
                $name = $model->get_name();
                $active = $model->is_active();

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);

                $model_updated = $stmt->execute();
            } catch (PDOException $ex) {
                if ($ex->getCode() == '45000') {
                    $pdo_exception = explode('│', $ex->getMessage());
                    static::$sql_exception = $pdo_exception[1];
                } else {
                    print 'ERROR: ' . $ex->getMessage() . '<br>';
                    print 'ERROR: ' . $ex->getCode() . gettype($ex->getCode()). '<br>';
                }
            }
        }

        return $model_updated;
    }

    public static function delete($connection, $user_id, $company_id, $id) {
        $deleted = false;

        if (isset($connection)) {
            try {
                $sql = 'CALL sp_' . static::$table . '_delete(:user_id, :company_id, :id)';

                $stmt = $connection->prepare($sql);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $deleted = $stmt->execute();
            } catch (PDOException $ex) {
                if ($ex->getCode() == '45000') {
                    $pdo_exception = explode('│', $ex->getMessage());
                    static::$sql_exception = $pdo_exception[1];
                } else {
                    print 'ERROR: ' . $ex->getMessage() . '<br>';
                    print 'ERROR: ' . $ex->getCode() . gettype($ex->getCode()). '<br>';
                }
            }
        }

        return $deleted;
    }

}
?>