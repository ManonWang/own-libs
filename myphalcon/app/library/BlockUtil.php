<?php

namespace MyPhalcon\App\Library;

class BlockUtil {

    private $redis = null;

    public function __construct($redis) {
        $this->redis = $redis;
    }

    public function checkFire($rules, $keys) {
        $type = $this->getType($rules);
        if ($type == 1) {
            return $this->absoluteGet($rules, $keys);
        } else {
            return $this->relativeGet($rules, $keys);
        }
    }

    private function relativeGet($rules, $keys) {
        foreach ($this->getKeys($keys) as $key) {
            $keyPrefix = $rules['prefix'] . $key;
            foreach ($rules['rules'] as $interval => $count) {
                $redisKey = sprintf($keyPrefix . '_%s', $interval);
                $nowCount = $this->redis->GET($redisKey);
                if ($nowCount >= $count) {
                    return true;
                }
            }
        }
        return false;
    }

    private function absoluteGet($rules, $keys) {
        $time = time();
        foreach ($this->getKeys($keys) as $key) {
            $keyPrefix = $rules['prefix'] . $key;
            foreach ($rules['rules'] as $interval => $count) {
                $redisKey = sprintf($keyPrefix . '_%s', $interval);
                $lenth = $this->redis->LLEN($redisKey);

                /*  这块看具体情况，有性能问题O(N)
                if ($lenth > $count) {
                    $this->redis->LTRIM($redisKey, 0, $count - 1);
                }
                */

                if ($lenth < $count) {
                    continue;
                }

                $first = $this->redis->LINDEX($redisKey, -1);
                if ($time - $first > $interval) {
                    continue;
                }

                return true;
            }
        }

        return false;
    }

    public function addCount($rules, $keys) {
        $type = $this->getType($rules);
        if ($type == 1) {
            $this->absoluteSet($rules, $keys);
        } else {
            $this->relativeSet($rules, $keys);
        }
    }

    private function relativeSet($rules, $keys) {
        foreach ($this->getKeys($keys) as $key) {
            $keyPrefix = $rules['prefix'] . $key;
            foreach ($rules['rules'] as $interval => $count) {
                $redisKey = sprintf($keyPrefix . '_%s', $interval);
                if ($this->redis->EXISTS($redisKey)) {
                    $this->redis->INCR($redisKey);
                } else {
                    $this->redis->SETEX($redisKey, $interval, 1);
                }
            }
        }
    }

    private function absoluteSet($rules, $keys) {
        $time = time();
        foreach ($this->getKeys($keys) as $key) {
            $keyPrefix = $rules['prefix'] . $key;
            foreach ($rules['rules'] as $interval => $count) {
                $redisKey = sprintf($keyPrefix . '_%s', $interval);
                $lenth = $this->redis->LLEN($redisKey);

                /*  这块看具体情况，有性能问题O(N)
                if ($lenth > $count) {
                    $this->redis->LTRIM($redisKey, 0, $count - 1);
                }
                */

                if ($lenth < $count) {
                    $this->redis->LPUSH($redisKey, $time);
                    $this->redis->EXPIRE($redisKey, $interval);
                    continue;
                }

                $first = $this->redis->LINDEX($redisKey, -1);
                if ($time - $first > $interval) {
                    $this->redis->RPOPLPUSH($redisKey, $time);
                    $this->redis->EXPIRE($redisKey, $interval);
                    continue;
                }
            }
        }
    }

    public function clearCount($rules, $keys) {
        foreach ($this->getKeys($keys) as $key) {
            $keyPrefix = $rules['prefix'] . $key;
            foreach ($rules['rules'] as $interval => $count) {
                $redisKey = sprintf($keyPrefix . '_%s', $interval);
                $this->redis->DEL($redisKey);
            }
        }
    }

    private function getKeys($keys) {
        return is_array($keys) ? $keys : array($keys);
    }

    private function getType($rules) {
        return $rules['type'] == 1 ? 1 : 2;
    }

}
