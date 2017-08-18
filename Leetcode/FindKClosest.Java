class Solution {
  public List<Integer> findSol(List<Integer> arr, int k, int x, int i,int l,int r, List<Integer>Sol)
  {
    int c = 1;
    while(c<k)
    {
      if(l < 0)
      {
        Sol.add(arr.get(r));
        r++;
      }
      else if(r >= arr.size())
      {
        Sol.add(arr.get(l));
        l--;
      }
      else if(l < 0 && r >= arr.size())  return Sol;
      else
      {
        if(Math.abs(arr.get(l) - x) <= Math.abs(arr.get(r) - x))
        {
          Sol.add(arr.get(l));
          l--;
        }
        else
        {
          Sol.add(arr.get(r));
          r++;
        }
      }
      c++;
    }
    Collections.sort(Sol);
    return Sol;
  }
  public List<Integer> findClosestElements(List<Integer> arr, int k, int x) {

    int l = 0; int nearest = 0; int arrsize = arr.size();
    List<Integer>Sol = new ArrayList<Integer>();
    if(x < arr.get(0))
    {
      int c = 0;
      while(c<k)
      {
        Sol.add(arr.get(c));
        t++;
      }
      return Sol;
    }

    if(x > arr.get(arrsize-1))
    {
      //int i = arr.size()-1;
      while(k > 0)
      {
        Sol.add(arr.get(arrsize-k-1));
        k--;
      }
      return Sol;
    }

    for (int i = 0; i < arrsize; i++) {
      if(arr.get(i)==x)
      {
        Sol.add(x);
        return findSol(arr,k,x,i,i-1,r+1,Sol);
      }
      else if (arr.get(i) < x) {
        nearest = arr.get(i);
        l = i;
      }
      else if(arr.get(i) > x)
      {
        if(arr.get(i) - x < x - nearest)
        {
          Sol.add(arr.get(i));
          return findSol(arr,k,x,i,l,i+1,Sol);
        }
        else
        {
          l -= 1;
          Sol.add(nearest);
          return findSol(arr,k,x,i,l,i,Sol);
        }
      }
    }
    return Sol;
  }
}
