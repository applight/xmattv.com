import Prelude as P

fibi = [1..]

fib :: Int -> Int
fib n = head (fib_h n [])

fib_h 0 lst =  lst
fib_h n lst =  fib_h (n-1) $ fseq lst
        
fseq [] = [1]
fseq [1] = [1,1]
fseq [1,1] = [2,1,1]
fseq seq@(m:(n:_)) = m+n : seq


that _ = map $ putStrLn $ fib_h 5 []

main = do 
    sq <- fib_h 5 []
    putStrLn sq
    return ()