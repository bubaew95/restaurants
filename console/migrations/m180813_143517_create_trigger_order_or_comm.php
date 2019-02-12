<?php

use yii\db\Migration;
use common\models\Orders;
use common\models\Menu;
use common\models\Comments;

/**
 * Class m180813_143517_create_trigger_order_or_comm
 */
class m180813_143517_create_trigger_order_or_comm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $trigger = "
                CREATE TRIGGER before_count_order_dish
                AFTER INSERT ON " . Orders::tableName() . " 
                FOR EACH ROW 
                BEGIN 
                    if((SELECT count(*) FROM {{%statistic_menu}} WHERE id_menu = new.id_menu) > 0) THEN
                        UPDATE {{%statistic_menu}} SET count_order = (count_order + 1) WHERE id_menu = new.id_menu;
                    else 
                        INSERT INTO {{%statistic_menu}} (id_menu, count_order) VALUES (new.id_menu, 1);
                    end if;
                END; 
            ";
            $this->execute($trigger);

            $trigger2 = "
                CREATE TRIGGER before_raiting_order_dish 
                AFTER INSERT ON " . Comments::tableName() . "
                FOR EACH ROW 
                BEGIN
                    if((SELECT count(*) FROM {{%statistic_menu}} WHERE id_menu = new.id_menu) > 0) THEN
                        UPDATE {{%statistic_menu}} SET count_comm = (count_comm + 1), raiting = ((raiting * count_comm + new.raiting) / (count_comm + 1)) WHERE id_menu = new.id_menu;
                    else 
                        INSERT INTO {{%statistic_menu}} (id_menu, raiting, count_comm) VALUES (new.id_menu, new.raiting, 1);
                    end if;
                END;
            ";
            $this->execute($trigger2);
        } else  {
            $function = "
                CREATE OR REPLACE FUNCTION before_count_order_dish() RETURNS TRIGGER AS $$
                BEGIN 
                    if((SELECT count(*) FROM {{%statistic_menu}} WHERE id_menu = new.id_menu) > 0) THEN
                        UPDATE {{%statistic_menu}} SET count_order = (count_order + 1) WHERE id_menu = new.id_menu;
                    else 
                        INSERT INTO {{%statistic_menu}} (id_menu, count_order) VALUES (new.id_menu, 1);
                    end if;
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
            ";
            $this->execute($function);

            $trigger = " 
                CREATE TRIGGER before_count_order_dish
                AFTER INSERT ON {{%orders}}
                FOR EACH ROW 
                EXECUTE PROCEDURE before_count_order_dish();
            ";
            $this->execute($trigger);

            $function2 = "
                CREATE OR REPLACE FUNCTION before_raiting_order_dish() RETURNS TRIGGER AS $$
                BEGIN 
                    if((SELECT count(*) FROM {{%statistic_menu}} WHERE id_menu = new.id_menu) > 0) THEN
                        UPDATE {{%statistic_menu}} SET count_comm = (count_comm + 1), raiting = ((raiting * count_comm + new.raiting) / (count_comm + 1)) WHERE id_menu = new.id_menu;
                    else 
                        INSERT INTO {{%statistic_menu}} (id_menu, raiting, count_comm) VALUES (new.id_menu, new.raiting, 1);
                    end if;
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
            ";
            $this->execute($function2);

            $trigger2 = " 
                CREATE TRIGGER before_raiting_order_dish
                AFTER INSERT ON {{%comments}}
                FOR EACH ROW 
                EXECUTE PROCEDURE before_raiting_order_dish();
            ";
            $this->execute($trigger2);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->db->driverName === 'mysql') {
            $trigger = "DROP TRIGGER IF EXISTS before_update_count_order_dish";
            $this->execute($trigger);
            $trigger2 = "DROP TRIGGER IF EXISTS before_raiting_order_dish";
            $this->execute($trigger2);
        } else {
            $trigger = "DROP TRIGGER before_count_order_dish ON {{%orders}}";
            $this->execute($trigger);
            $trigger2 = "DROP TRIGGER before_raiting_order_dish ON {{%comments}}";
            $this->execute($trigger2);
        }
    }

}
