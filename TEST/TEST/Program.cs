using System;

public class Assignment
{
    public static void Main(string[] args)
    {
        double radius;

        Console.WriteLine("Enter Radius: ");
        radius = double.Parse(Console.ReadLine());

        double Area, Circumference;

        Area = Math.PI * radius * radius;
        Circumference = 2 * Math.PI * radius;

        Console.WriteLine($"The area of a circle with radius {radius} is {Area}");
        Console.WriteLine($"The circumference of a circle is {Circumference}");
    }
}
