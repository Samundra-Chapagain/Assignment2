using System;

namespace MyApplication
{
    class Program
    {
        static void Main(string[] args)
        {
             
            int a = 2;
            int b = 3;
            int c = 4;
            int sum = (a + b + c);

            


            if (sum % 2 == 0) 
            {
                Console.WriteLine("even");
            }
            else
            {
                Console.WriteLine("odd");
            }
        }
    }
}